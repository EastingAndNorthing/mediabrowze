<?php

$currentpage = 'account';

require_once('loader.php');
require_once('views/header.php');

$userhandler->authRedirect('login.php');

if(isset($_GET['add_user_media'])) {
  // Add a media item to the account if this get parameter is set
  $usermedia_msg = $mediahandler->addUserMedia($_SESSION['user']->id, $_GET['add_user_media']);
}

if(isset($_GET['delete_user_media'])) {
  // Remove a media item from the account if this get parameter is set
  $usermedia_msg = $mediahandler->deleteUserMedia($_SESSION['user']->id, $_GET['delete_user_media']);
}

// Get the current userdata and media of the user

$userdata = $userhandler->getUserData($_SESSION['user']->id);
$usermedia = $mediahandler->getUserMedia($_SESSION['user']->id);

?>

<div class="max width">
  <h1><?php echo $_SESSION['user']->fname; ?>'s account</h1>

  <?php

    // If adding media was succesful, notify the user.

    if(isset($usermedia_msg)) { echo $usermedia_msg; }

    // Initialize a new View to show the media of the user

    $view = new View('views/media/media_list.php');

    $view->assign('media', $usermedia); // Assign the user's media to the view
    $view->assign('accountview', true); // Replace the 'add' button with a 'remove' button on the account page
    $view->render();

  ?>
</div>

<?php

require_once('views/footer.php');
