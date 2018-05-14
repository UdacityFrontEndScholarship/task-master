<?php

//echo "Add_USer.php";

require_once('db/load.php');

// Handle logins
if($_SERVER["REQUEST_METHOD"] == "POST") {

    $adduser_status = $login->register($_POST);

    if($adduser_status['status']){

      $login_status = $login->verify_login($_POST);
    }
}

// Verify session
if ( $login->verify_session() ) {
    $user = $login->user;
    //echo "Login successful";
    redirect( 'profile.php' );
    //include( 'profile.php' );

} else {
    //echo "Login failed";
    redirect( '../login.php' );
    //include( '../login.php'  );

}
