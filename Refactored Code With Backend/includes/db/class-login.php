<?php
class Login {
    public $user;

    public function __construct() {
        global $db;

        session_start();

        $this->db = $db;
    }

    public function verify_session() {
        if ( ! isset( $_SESSION['username'] ) ) {
            return false;
        }

        $username = $_SESSION['username'];

        if ( empty( $username ) && ! empty( $_COOKIE['rememberme'] ) ) {
            list($selector, $authenticator) = explode(':', $_COOKIE['rememberme']);

            $results = $this->db->get_results("SELECT * FROM auth_tokens WHERE selector = :selector", ['selector'=>$selector]);
            $auth_token = $results[0];

            if ( hash_equals( $auth_token->token, hash( 'sha256', base64_decode( $authenticator ) ) ) ) {
                $username = $auth_token->username;
                $_SESSION['username'] = $username;
            }
        }

        $user =  $this->user_exists( $username );

        if ( false !== $user ) {
            $this->user = $user;

            return true;
        }

        return false;
    }

    public function verify_login($post) {
        if ( ! isset( $post['email'] ) || ! isset( $post['password'] ) ) {
            return false;
        }

        // Check if user exists
        $user = $this->user_exists( $post['email'] , 'email');

        if ( false !== $user ) {
            if ( password_verify( $post['password'], $user->password ) ) {
                $_SESSION['email'] = $user->email;
                $_SESSION['username'] = $user->username;

                if ( isset( $post['rememberme'] ) ) {
                    $this->rememberme($user);
                }

                return true;
            }
        }

        return false;
    }

    public function register($post) {
      // Required fields
      $required = array( 'username', 'password', 'email', 'firstname', 'lastname');

      foreach ( $required as $key ) {
          if ( empty( $post[$key] ) ) {
              return array('status'=>0,'message'=>sprintf('Please enter your %s', $key));
          }
      }

      // Check if username exists already
      if ( false !== $this->user_exists( $post['username'] ) ) {
          return array('status'=>0,'message'=>'Username already exists');
      }

      // Create if doesn't exist
      $insert = $this->db->insert('users',
          array(
              'username'  =>  $post['username'],
              'password'  =>  password_hash($post['password'], PASSWORD_DEFAULT),
              'firstname'      =>  $post['firstname'],
              'lastname'      =>  $post['lastname'],
              'email'     =>  $post['email'],
          )
      );

      if ( $insert == true ) {
          return array('status'=>1,'message'=>'Account created successfully');
      }

      return array('status'=>0,'message'=>'An unknown error occurred.');
    }

    public function lost_password($post) {
        // Verify email submitted
        if ( empty( $post['email'] ) ) {
            return array('status'=>0,'message'=>'Please enter your email address');
        }

        // Verify email exists
        if ( ! $user = $this->user_exists( $post['email'], 'email' ) ) {
            return array('status'=>0,'message'=>'That email address does not exist in our records');
        }

        // Create tokens
        $selector = bin2hex(random_bytes(8));
        $token = random_bytes(32);

        $url = sprintf('%sreset.php?%s', ABS_URL, http_build_query([
            'selector' => $selector,
            'validator' => bin2hex($token)
        ]));

        // Token expiration
        $expires = new DateTime('NOW');
        $expires->add(new DateInterval('PT01H')); // 1 hour

        // Delete any existing tokens for this user
        $this->db->delete('password_reset', 'email', $user->email);

        // Insert reset token into database
        $insert = $this->db->insert('password_reset',
            array(
                'email'     =>  $user->email,
                'selector'  =>  $selector,
                'token'     =>  hash('sha256', $token),
                'expires'   =>  $expires->format('U'),
            )
        );

        // Send the email
        if ( false !== $insert ) {
            // Recipient
            $to = $user->email;

            // Subject
            $subject = 'Your password reset link';

            // Message
            $message = '<p>We recieved a password reset request. The link to reset your password is below. ';
            $message .= 'If you did not make this request, you can ignore this email</p>';
            $message .= '<p>Here is your password reset link:</br>';
            $message .= sprintf('<a href="%s">%s</a></p>', $url, $url);
            $message .= '<p>Thanks!</p>';

            // Headers
            $headers = "From: " . ADMIN_NAME . " <" . ADMIN_EMAIL . ">\r\n";
            $headers .= "Reply-To: " . ADMIN_EMAIL . "\r\n";
            $headers .= "Content-type: text/html\r\n";

            // Send email
            $sent = mail($to, $subject, $message, $headers);
        }

        if ( false !== $sent ) {
            // If they're resetting their password, we're making sure they're logged out
            session_destroy();

            return array('status'=>1,'message'=>'Check your email for the password reset link');
        }

        return array('status'=>0,'message'=>'There was an error send your password reset link');
    }

    public function reset_password($post) {
        // Required fields
        $required = array( 'selector', 'validator', 'password' );

        foreach ( $required as $key ) {
            if ( empty( $post[$key] ) ) {
                return array('status'=>0,'message'=>'There was an error processing your request. Error Code: 001');
            }
        }

        extract($post);

        // Get tokens
        $results = $this->db->get_results("SELECT * FROM password_reset WHERE selector = :selector AND expires >= :time", ['selector'=>$selector,'time'=>time()]);

        if ( empty( $results ) ) {
            return array('status'=>0,'message'=>'There was an error processing your request. Error Code: 002');
        }

        $auth_token = $results[0];
        $calc = hash('sha256', hex2bin($validator));

        // Validate tokens
        if ( hash_equals( $calc, $auth_token->token ) )  {
            $user = $this->user_exists($auth_token->email, 'email');

            if ( false === $user ) {
                return array('status'=>0,'message'=>'There was an error processing your request. Error Code: 003');
            }

            // Update password
            $update = $this->db->update('users',
                array(
                    'password'  =>  password_hash($password, PASSWORD_DEFAULT),
                ), $user->ID
            );

            // Delete any existing password reset AND remember me tokens for this user
            $this->db->delete('password_reset', 'email', $user->email);
            $this->db->delete('auth_tokens', 'username', $user->username);

            if ( $update == true ) {
                // New password. New session.
                session_destroy();

                return array('status'=>1,'message'=>'Password updated successfully. <a href="index.php">Login here</a>');
            }
        }

        return array('status'=>0,'message'=>'There was an error processing your request. Error Code: 004');
    }



    public function add_task($post) {
      // Required fields
      $required = array( 'title', 'description', 'priority', 'alarm_time', 'alarm_type', 'deadline');

      foreach ( $required as $key ) {
          if ( empty( $post[$key] ) ) {
              return array('status'=>0,'message'=>sprintf('Please enter your %s', $key));
          }
      }


      // Create if doesn't exist
      $insert = $this->db->insert('tasks',
          array(
              'task_title'  =>  $post['title'],
              'task_description'  =>  $post['description'],
              'task_priority'      =>  $post['priority'],
              'task_deadline'      =>  $post['deadline'],
              'task_alarm_type'     =>  $post['alarm_type'],
              'task_alarm_time'     =>  $post['alarm_time'],
              'email'     =>  $_SESSION['email']
          )
      );

      if ( $insert == true ) {
          return array('status'=>1,'message'=>'Account created successfully');
      }

      return array('status'=>0,'message'=>'An unknown error occurred.');
    }

    public function update_db_for_profile_pic($user_name) {

      $update = $this->db->update_based_email('users',
          array('profile_photo' =>  $user_name),
          $_SESSION['email']
        );

      if ( $update == true ) {
          return array('status'=>1,'message'=>'Profile Pic updated successfully');
      }

      return array('status'=>0,'message'=>'An unknown error occurred.');
    }


    public function top5_tasks($email) {
      // Get tokens
      $results = $this->db->get_records("SELECT * FROM tasks WHERE email = :email ORDER BY task_deadline  limit 5",['email'=>$email]);

      if ( empty( $results ) ) {
          return array('status'=>0,'message'=>'There was an error processing your request. Error Code: 002');
      }

      $records = $results[0] ;
      foreach ($records as $record){

$card =<<<DELEMETER
          <div class="col s12">
      <div class="card">
          <div class="card-content grey">
                <a class="right"><i class="material-icons teal-text icon">close</i></a>
                <a href="#modal2" class="modal-trigger right"><i class="material-icons teal-text icon">create</i></a>
                <h6 class="card-title">$record->task_title</h6>
                <p>Description about task</p>
          </div>
          <div class="card-action">
                <div class="row">
                    <span class="new badge left" data-badge-caption="">$record->task_deadline</span>
                    <span class="new badge left" data-badge-caption="">$record->task_alarm_time</span>
                    <span class="new badge left grey" data-badge-caption="">$record->task_priority</span>
                    <span class="new badge left" data-badge-caption="">$record->task_alarm_type</span>
                </div>
                <div class="row center">
                  <div class="switch right">
                    <label>Pending<input type="checkbox" checked><span class="lever"></span>Done</label>
                  </div>
                </div>
         </div>
       </div>
</div>
DELEMETER;
            echo $card ;

      }

    }


    public function get_profile_info($email) {
      // Get tokens
      $results = $this->db->get_results("SELECT * FROM users WHERE email = :email ",['email'=>$email]);

      if ( empty( $results ) ) {
          return array('status'=>0,'message'=>'There was an error processing your request. Error Code: 002');
      }

      $number_of_pending_tasks = $this->get_number_of_tasks($email);
      $change_pic = $this->change_profile_pic($email);
      //print_r($results);
      $full_name =  $results[0]->firstname;
      $full_name .= " ";
      $full_name .=  $results[0]->lastname;

      $profile_pic = "../img/profile_photos/" . $results[0]->profile_photo;
      //echo $profile_pic;
      //echo $full_name;
    $user =<<<DELEMETER
    <div class="col s4 picture-div">

            <div class="profile-card">
                <div class="profile-photo">
                      <img class="profile_pic" src="$profile_pic" alt="">
                </div>


                $change_pic
            </div> <!---profile-card-->

        </div> <!---col s4 picture-div-->

        <div class="col s8">
              <div class="user-name-div">
                    <h2 class="user-name">
                      <i class="material-icons">account_circle</i>
                      <span class="left-space">$full_name</span>
                    </h2>


                    <h6 class="user-info">
                      <i class="material-icons">date_range</i>
                      <span class="left-space">Task Pending: $number_of_pending_tasks</span>
                    </h6>

              </div> <!---user-name-div-->
        </div> <!---col s8-->

DELEMETER;
    echo $user ;



    }


    public function change_profile_pic($email) {

      $results  = $this->db->get_results("SELECT * FROM users WHERE email = :email ",['email'=>$email]);

      if ( empty( $results ) ) {
          return array('status'=>0,'message'=>'There was an error processing your request. Error Code: 002');
      };

      //print_r($results);

      $user_name = $results[0]->username ;
      $user =<<<DELEMETER

      <div class="container file-upload">
            <form method="post" enctype="multipart/form-data">
              <input type="hidden" name="user_name" value="{$user_name}">
              <input type="file" name="fileToUpload" id="fileToUpload">
              <br>
              <td><input class="btn btn-danger" type="submit" name="change_pic" value="Change Profile Pic"></td>
            </form>
      </div>

DELEMETER;
          return $user ;
    }




    public function get_number_of_tasks($email, $task_status='pending') {
      // Get tokens
      $results = $this->db->get_number_of_rows("SELECT * FROM tasks WHERE email = :email and task_status = :task_status",['email'=>$email, 'task_status'=>$task_status]);
      //print_r ($results);
      return($results);

    }

    private function rememberme($user) {
        $selector = base64_encode(random_bytes(9));
        $authenticator = random_bytes(33);

        // Set rememberme cookie
        setcookie(
            'rememberme',
            $selector.':'.base64_encode($authenticator),
            time() + 864000,
            '/',
            '',
            true,
            true
        );

        // Clean up old tokens
        $this->db->delete('auth_tokens', 'username', $user->username);

        // Insert auth token into database
        $insert = $this->db->insert('auth_tokens',
            array(
                'selector'  =>  $selector,
                'token'     =>  hash('sha256', $authenticator),
                'username'  =>  $user->username,
                'expires'   =>  date('Y-m-d\TH:i:s', time() + 864000),
            )
        );
    }

    private function user_exists($where_value, $where_field = 'username') {
        $user = $this->db->get_results("
            SELECT * FROM users
            WHERE {$where_field} = :where_value",
            ['where_value'=>$where_value]
        );

        if ( false !== $user ) {
            return $user[0];
        }

        return false;
    }
}

$login = new Login;
