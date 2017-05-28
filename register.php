<?php

require_once('loader.php');
require_once('views/header.php');

// If the form is submitted, let $userhandler->login() handle the form.
// The login function returns a message to indicate success or faillure.
if(isset($_POST['user_register_submit'])) {
  $register_msg = $userhandler->register($_POST['username'], $_POST['password'], $_POST['password2'], $_POST['fname'], $_POST['lname']);
}

?>

<div class="max width">
  <h1>Register</h1>

  <form action="" method="post">
    <input type="text" name="username" placeholder="Username" value="<?php if(isset($_POST['username'])) echo $_POST['username']; ?>" required>
    <input type="password" name="password" placeholder="Password" required>
    <input type="password" name="password2" placeholder="Repeat password" required>
    <input type="text" name="fname" placeholder="First name" value="<?php if(isset($_POST['fname'])) echo $_POST['fname']; ?>" required>
    <input type="text" name="lname" placeholder="Last name" value="<?php if(isset($_POST['lname'])) echo $_POST['lname']; ?>" required>
    <input type="submit" name="user_register_submit" value="Register">
  </form>
  <br>
  <?php
    // If there are any errors, print them so the user can see what went wrong.
    if(isset($register_msg)){ echo $register_msg; }
  ?>
</div>

<?php

require_once('views/footer.php');
