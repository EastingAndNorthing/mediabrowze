<?php
require_once('loader.php');

// Check if a user is logged in (registered in the session)
if(isset($_SESSION['user'])) {
  // Log out and end the current session
  $userhandler->logout();
}

header('Location: index.php');
