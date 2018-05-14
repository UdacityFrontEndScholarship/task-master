
<form class="col s12 z-depth-5 white lighten-5" action="includes/add_user.php"  method="post">
  <div class="row ">

    <div class="input-field col s12 m6 l6 xl6">
      <i class="material-icons prefix">account_circle</i>
      <input type="text" id="firstname" name="firstname" class="black-text validate">
      <label class="active"  for="firstname">First Name</label>
    </div>

    <div class="input-field col s12 m6 l6 xl6">
      <i class="material-icons prefix">account_circle</i>
      <input type="text" id="lastname" name="lastname" class="black-text validate">
      <label class="active" for="lastname">Last Name</label>
    </div>

    <div class="input-field col s12 m6 l6 xl6">
      <i class="material-icons prefix">email</i>
      <input type="email" id="email" name="email" class="black-text validate">
      <label class="active" for="email">Email</label>
    </div>

    <div class="input-field col s12 m6 l6 xl6">
      <i class="material-icons prefix">person</i>
      <input type="text" id="username"  name="username" class="black-text  validate">
      <label class="active" for="username">User Name</label>
    </div>

    <div class="input-field col s12 m6 l6 xl6">
      <i class="material-icons prefix">lock</i>
      <input type="password" id="password" name="password"  class="black-text validate">
      <label class="active" for="password">Password</label>
    </div>

    <div class="input-field col s12 m6 l6 x16">
      <i class="material-icons prefix">lock</i>
      <input type="password" class="black-text  validate">
      <label class="active">Confirm Password</label>
    </div>

  </div>

  <div class="row ">
    <div class="col s16 m12 20 x16 ">
      <button class="btn grey darken-3 z-depth-5 center col s12 waves-effect waves-light" id="color">Sign Up</button>
    </div>
  </div>
  
</form>
