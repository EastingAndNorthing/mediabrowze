<?php

require_once('loader.php');
require_once('views/header.php');

?>

<div class="max width">
  <h1>Search</h1>
  <form action="" method="get">
    <input type="text" name="query" placeholder="Find media...">
    <!-- <input type="text" name="user" placeholder="Find users"> -->
    <input type="submit" value="Search">
  </form>
  <?php
    if(isset($_GET['query'])){
      $media = $mediahandler->searchMedia($_GET['query']);
      $view = new view('views/media/media_list.php');
      $view->assign('media', $media);
      $view->render();
    }

    // if(isset($_GET['user'])){
    //   $media = $mediahandler->getUserMedia($_GET['user']);
    //   $mediahandler->viewMedia($media);
    // }
  ?>
</div>

<?php

require_once('views/footer.php');
