<?php

global $userhandler; // Refer to these global variables, set in loader.php
global $mediahandler;

$userhandler->authRedirect('login.php', true);

if(isset($_POST['media_update_submit'])) {
  // Leading zero on months and days
  $month = sprintf("%02d", $_POST['release_date_m']);
  $day = sprintf("%02d", $_POST['release_date_d']);
  $year = $_POST['release_date_y'];

  // Formating the date for the database: yyyy-mm-dd
  $release_date = "$year-$month-$day";

  $creation_msg = $mediahandler->updateMedia($_GET['media_update'], $_POST['media_name'], $_POST['media_description'], $_FILES['media_cover'], $release_date, $_POST['category_id']);
}

$media = $mediahandler->getMediaById(intVal($_GET['media_update']));

// Convert the release date back to it's parts: day / month / year

$release_date = explode('-', $media['release_date']);

$release_date_y = $release_date[0];
$release_date_m = $release_date[1];
$release_date_d = $release_date[2];


?>


<h3>Edit media</h3>

<form action="" method="post" enctype="multipart/form-data">
  <input type="text" name="media_name" placeholder="Media name" value="<?php echo $media['media_name']; ?>" required>
  <textarea type="password" name="media_description" placeholder="Media description"><?php echo $media['media_description']; ?></textarea>
  <label for="media_cover">Media cover</label>
  <input type="file" name="media_cover" accept="image/*" required>
  <fieldset>
    <label for="release_date">Release date</label>
    <input type="number" name="release_date_d" placeholder="Day" min="1" max="31" value="<?php echo $release_date_d; ?>">
    <input type="number" name="release_date_m" placeholder="Month" min="1" max="12" value="<?php echo $release_date_m; ?>">
    <input type="number" name="release_date_y" placeholder="Year" min="1000" max="3000" value="<?php echo $release_date_y; ?>">
  </fieldset>
  <?php
    $dropdown = new View('views/category/dropdown.php');
    $dropdown->render();
  ?>
  <br><br>
  <input type="submit" name="media_update_submit" value="Update">
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
