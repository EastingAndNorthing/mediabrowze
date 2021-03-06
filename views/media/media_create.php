<?php

global $userhandler; // Refer to these global variables, set in loader.php
global $mediahandler;

$userhandler->authRedirect('login.php', true);

if(isset($_POST['media_create_submit'])) {
  // Leading zero on months and days
  $day = sprintf("%02d", $_POST['release_date_d']);
  $month = sprintf("%02d", $_POST['release_date_m']);
  $year = $_POST['release_date_y'];

  $release_date = '';

  if($day && $month && $year) {
    // Formating the date for the database: yyyy-mm-dd
    $release_date = "$year-$month-$day";
  }

  $creation_msg = $mediahandler->createMedia($_POST['media_name'], $_POST['media_description'], $_FILES['media_cover'], $release_date, $_POST['category_id']);

}

?>

<h3>Add media</h3>

<form action="" method="post" enctype="multipart/form-data">
  <input type="text" name="media_name" placeholder="Media name" value="<?php if(isset($_POST['media_name'])) echo $_POST['media_name']; ?>" required>
  <textarea type="password" name="media_description" placeholder="Media description"><?php if(isset($_POST['media_description'])) echo $_POST['media_description']; ?></textarea>
  <label for="media_cover">Media cover</label>
  <input type="file" name="media_cover" accept="image/*" value="<?php if(isset($_FILES['media_cover'])) echo $_FILES['media_cover']; ?>" required>
  <fieldset>
    <label for="release_date">Release date</label>
    <input type="number" name="release_date_d" placeholder="Day" min="1" max="31" value="<?php if(isset($_POST['release_date_d'])) echo $_POST['release_date_d']; ?>" required>
    <input type="number" name="release_date_m" placeholder="Month" min="1" max="12" value="<?php if(isset($_POST['release_date_m'])) echo $_POST['release_date_m']; ?>" required>
    <input type="number" name="release_date_y" placeholder="Year" min="1000" max="3000" value="<?php if(isset($_POST['release_date_y'])) echo $_POST['release_date_y']; ?>" required>
  </fieldset>
  <?php
    $dropdown = new View('views/category/dropdown.php');
    $dropdown->render();
  ?>
  <br><br>
  <input type="submit" name="media_create_submit" value="Create">
</form>
<br>
<div class="error-container">
  <?php
    // If there are any errors, print them so the user can see what went wrong.
    if(isset($upload['errors'])){ echo $upload['errors']; }
    // If creation was succesful, notify the user.
    if(isset($creation_msg)) { echo $creation_msg; }
  ?>
</div>
