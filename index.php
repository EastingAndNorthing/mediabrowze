<?php

$currentpage = 'home';

require_once('loader.php');
require_once('views/header.php');

?>

<div class="max width">
  <h1>Public media</h1>

  <?php

    // Get all media
    $media = $mediahandler->getMedia();

    // Create a new View to list the media, assign $media to it and render it to the page.
    $view = new view('views/media/media_list.php');
    $view->assign('media', $media);
    $view->render();

  ?>

</div>

<?php

require_once('views/footer.php');
