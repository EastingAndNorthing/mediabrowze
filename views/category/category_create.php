<?php

global $userhandler; // Refer to these global variables, set in loader.php
global $categoryhandler;

$userhandler->authRedirect('login.php', true);

if(isset($_POST['category_create_submit'])) {
  $creation_msg = $categoryhandler->createCategory($_POST['category_name'], $_POST['category_color']);
}

?>

<h3>Add Category</h3>

<form action="" method="post">
  <input type="text" name="category_name" placeholder="Category Name" value="<?php if(isset($_POST['category_name'])) echo $_POST['category_name']; ?>" required>
  <label for="category_color">Color</label>
  <input type="color" name="category_color" value="<?php if(isset($_POST['category_color'])) echo $_POST['category_color']; ?>" required>
  <input type="submit" name="category_create_submit" value="Create">
</form>
<br>
<?php
  // If creation was succesful, notify the user.
  if(isset($creation_msg)) { echo $creation_msg; }
?>
