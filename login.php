<?php

require_once('loader.php');
require_once('views/header.php');

// If the form is submitted, let $userhandler->login() handle the form.
// The login function returns a message to indicate success or faillure.
if(isset($_POST['user_login_submit'])) {
  $login_msg = $userhandler->login($_POST['username'], $_POST['password']);
}

// Check if a user is already set in the session (logged in)
if(isset($_SESSION['user'])) {
  // Redirect back to account page: a user should not be able to log in twice.
  header('Location: account.php');
}

?>

<div class="max width">
  <h1>Login</h1>

  <p>Don't have an account yet? <a href="register.php">Register now.</a></p>
  
  <form action="" method="post">
    <input type="text" name="username" placeholder="Username">
    <input type="password" name="password" placeholder="Password">
    <input type="submit" name="user_login_submit" value="Login">
  </form>
  <br>
  <?php
    // If there are any errors, print them so the user can see what went wrong.
    if(isset($login_msg)){ echo $login_msg; }
  ?>
</div>


<?php

require_once('views/footer.php');
