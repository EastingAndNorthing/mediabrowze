<?php

require_once('loader.php');
require_once('views/header.php');

// Check if we have a valid user and if they have admin permissions. Otherwise, redirect to the login page.
$userhandler->authRedirect('login.php', true);

?>

<div class="max width">
  <h1>Administration</h1>
  <h3>Choose an option</h3>
  <nav class="quicknav">
    <a href="admin.php">Dashboard</a>
    <a href="admin.php?user">Users</a>
    <a href="admin.php?media">Media</a>
    <a href="admin.php?category">Categories</a>
  </nav>
  <hr>

  <?php

    // Admin.php may show multiple types of views for all of the different data types based on $_GET values:

    // Initialise the View class to render the view
    $view = new View;

    // Set the view based on the get parameter
    if(empty($_GET)){ $view->set('views/dashboard.php'); }
    if(isset($_GET['user'])){ $view->set('views/user/table.php'); }
    if(isset($_GET['media'])){ $view->set('views/media/table.php'); }
    if(isset($_GET['media_create'])){ $view->set('views/media/media_create.php'); }
    if(isset($_GET['media_update'])){ $view->set('views/media/media_update.php'); }
    if(isset($_GET['category'])){ $view->set('views/category/table.php'); }
    if(isset($_GET['category_create'])){ $view->set('views/category/category_create.php'); }
    if(isset($_GET['category_update'])){ $view->set('views/category/category_update.php'); }

    // Render the view
    $view->render();

  ?>

</div>

<?php

require_once('views/footer.php');
