<?php

require_once('loader.php');
require_once('views/header.php');

$userhandler->authRedirect('login.php');

if(isset($_GET['add_user_media'])) {
  // Add a media item to the account if a get parameter is set
  $addmedia_msg = $mediahandler->addUserMedia($_SESSION['user']->id, $_GET['add_user_media']);
}

if(isset($_GET['delete_user_media'])) {
  // Add a media item to the account if a get parameter is set
  $addmedia_msg = $mediahandler->deleteUserMedia($_SESSION['user']->id, $_GET['delete_user_media']);
}

// Get the current userdata and media of the user

$userdata = $userhandler->getUserData($_SESSION['user']->id);
$usermedia = $mediahandler->getUserMedia($_SESSION['user']->id);

?>

<div class="max width">
  <h1><?php echo $_SESSION['user']->fname; ?>'s media</h1>

  <?php

    // If adding media was succesful, notify the user.
    if(isset($addmedia_msg)) { echo $addmedia_msg; }

    // Initialize a new View to show the users media

    $view = new view('views/media/media_list.php');
    $view->assign('media', $usermedia); // Assign the user's media to the view
    $view->assign('accountview', true); // Don't show the 'add' button if we're on the account page
    $view->render();

  ?>
</div>

<?php

require_once('views/footer.php');
