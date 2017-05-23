<h2>Media</h2>

<?php

  global $mediahandler; // Refer to this global variable, set in loader.php

  if(isset($_GET['media_delete'])) {
    $delete_msg = $mediahandler->deleteMedia($_GET['media_delete']);
  }

  if(isset($delete_msg)) { echo "<p>$delete_msg</p>"; }

  // Here, we pass an ORDER BY argument to getMedia().
  $media = $mediahandler->getMedia('ORDER BY media.media_id');


  if(!empty($media)): ?>
    <table>
    <tr>
      <th>ID</th>
      <th>Cover</th>
      <th>Name</th>
      <th>Category</th>
      <th>Creation date</th>
      <th>Edit</th>
    </tr>
     <?php foreach($media as $media): ?>
        <tr>
          <td><?php echo $media['media_id']; ?></td>
          <td><img src="media/<?php echo $media['media_cover']; ?>"></td>
          <td><?php echo $media['media_name']; ?></td>
          <td><?php echo $media['category_name']; ?></td>
          <td><?php echo $media['media_created_at']; ?></td>
          <td width="10%" class="editables">
            <a href="admin.php?media_update=<?php echo $media['media_id']; ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
            <a href="admin.php?media&media_delete=<?php echo $media['media_id']; ?>"><i class="fa fa-trash" aria-hidden="true"></i></a>
          </td>
        </tr>
     <?php endforeach; ?>
    </table>
    <br>

  <?php else: ?>
    <p>No media found.</p>
  <?php endif; ?>

  <a class="btn btn-primary floatright" href="admin.php?media_create">Add new...</a>
