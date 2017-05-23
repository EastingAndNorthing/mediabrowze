<?php

// Enable debugging messages
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Set a constant variable to refer to our base directory.
define('BASEPATH', __DIR__.'/');

// Require all include files
require_once(BASEPATH.'includes/DB.php');
require_once(BASEPATH.'includes/User.php');
require_once(BASEPATH.'includes/View.php');
require_once(BASEPATH.'includes/UserHandler.php');
require_once(BASEPATH.'includes/MediaHandler.php');
require_once(BASEPATH.'includes/FileHandler.php');
require_once(BASEPATH.'includes/CategoryHandler.php');
require_once(BASEPATH.'includes/ContactHandler.php');

// Initialise the DB class
$db = new DB;

// If DB has succesfully made a connection, load UserHandler, MediaHandler and CategoryHandler.
if($db->conn){

  // Inject our database connection into UserHandler and MediaHandler as arguments through the constructor function
  $userhandler = new UserHandler($db->conn);
  $mediahandler = new MediaHandler($db->conn, new FileHandler);
  $categoryhandler = new CategoryHandler($db->conn);

}

// Initialise the contact form class
$contacthandler = new ContactHandler;

// note: the global variables above are available in included files by calling 'global $var' within the file.
