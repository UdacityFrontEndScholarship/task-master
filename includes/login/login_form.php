<div id="box">
  <div class="z-depth-5 white row" id="form-block">
      <h5 class="grey-text darken-4">Login into your account</h5>

    <form  action="includes/auth_user.php" method="post">
      <div class='row'>

          <div class='input-field col s12'>
            <i class="material-icons prefix">email</i>
            <input id="email" name='email' type="email" class="validate">
            <label for="email">Email</label>
          </div>

          <div class='input-field col s12'>
            <i class="material-icons prefix">lock</i>
            <input id="password" name='password' type="password" class="validate">
            <label for="password">Password</label>
          </div>

          <div class="col s12">
            <label style='float: right;'>
                  <a class='red-text' href='#!'>Forgot Password?</a>
            </label>
          </div>

          <div class='col s12'>
            <button type='submit' name='btn_login' class='btn grey darken-3 z-depth-5 center col s12 waves-effect waves-light'>Login</button>
          </div>

          <div class='col s12'>
            <p class="choice">Or Sign In with</p>
              <button type='submit' name='gmail_login' class='btn red darken-3 z-depth-5 center col s12 waves-effect waves-light'>Google</button>
          </div>

        </div>
    </form>

  </div>

  <div class="container">
      <span>Not a member yet? <a href="signup.php">Create account</a></span>
  </div>

</div>
