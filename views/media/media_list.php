<?php

// Get the current URL and remove any get parameters by 'exploding' the url after '?'.
// The first index of the returned array contains the base url (ie. admin.php / user.php)

$url = explode('?', $_SERVER['REQUEST_URI']);
$base_url = $url[0];

?>

<h3>Order by:</h3>
<nav class="quicknav">
  <a href="<?php echo "$base_url?media_orderby=abc"; ?>">Alphabet</a>
  <a href="<?php echo "$base_url?media_orderby=releasedate"; ?>">Releasedate</a>
</nav>
<?php
  $dropdown = new View('views/category/dropdown.php');
  $dropdown->assign('directlink', true);
  $dropdown->render();
?>
<br>
<hr>

<?php

// Display HTML for media items, if $media is not empty
if(!empty($media)){

  // Loop through the media items and display HTML
  foreach($media as $media): ?>
    <div class='media-item'>
      <img class='media-cover' src='media/<?php echo $media['media_cover']; ?>'>
      <div class='media-info'>

        <?php if(!isset($accountview)): // Don't show the 'add' button if we're on the account page ?>
          <a href="account.php?add_user_media=<?php echo $media['media_id']; ?>" class="btn btn-primary floatright">Add</a>
        <?php else: ?>
          <a href="account.php?delete_user_media=<?php echo $media['media_id']; ?>" class="btn btn-primary floatright">Remove</a>
        <?php endif; ?>

        <h3><?php echo $media['media_name']; ?></h3>
        <h4 class='media-category' style='color: #<?php echo $media['category_color']; ?>;'><?php echo $media['category_name']; ?></h4>
        <p>Release: <?php echo $media['release_date']; ?></p>
        <p><?php echo $media['media_description']; ?></p>

      </div>
    </div>
    <hr>
  <?php endforeach;
} else {
  // If $media is empty, notify the user
  echo "No media found.";
}
