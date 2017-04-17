<?php

$userhandler->authRedirect('login.php', true);

if(isset($_POST['media_create_submit'])) {
  $creationmsg = $userhandler->register($_POST['media_name'], $_POST['media_description'], $_FILES["media_cover"], $_POST['release_date'], $_POST['category_id']);
}

?>

<h1>Add media</h1>

<form action="" method="post" enctype="multipart/form-data">
  <input type="text" name="media_name" placeholder="Media name">
  <textarea type="password" name="media_description" placeholder="Media description"></textarea>
  <label for="media_cover">Media cover</label>
  <input type="file" name="media_cover" accept="image/*">
  <label for="media_cover">Release date (YY-MM-DD)</label>
  <input type="text" name="release_date" placeholder="2016-02-14">
  <input type="number" name="category_id" placeholder="Category">
  <input type="submit" name="media_create_submit" value="Create">
</form>
<br>
<div class="error-container">
  <?php
    if(isset($upload['errors'])){ echo $upload['errors']; }
    if(isset($creationmsg)) { echo $creationmsg; }
  ?>
</div>
