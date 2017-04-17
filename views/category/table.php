<h2>Categories</h2>
<p>Warning: removing a category will also remove all attached media.</p>

<?php

  global $categoryhandler; // Refer to this global variable, set in loader.php

  if(isset($_GET['category_delete'])) {
    $delete_msg = $categoryhandler->deleteCategory($_GET['category_delete']);
  }

  if(isset($delete_msg)) { echo "<p>$delete_msg</p>"; }

  $categories = $categoryhandler->getCategories();

  if(!empty($categories)): ?>
    <table>
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Color</th>
      <th>Edit</th>
    </tr>
     <?php foreach($categories as $category): ?>
        <tr>
          <td><?php echo $category['category_id']; ?></td>
          <td><?php echo $category['category_name']; ?></td>
          <td><div class="color" style='background-color: #<?php echo $category['category_color']; ?>'></div></td>
          <td width="10%" class="editables">
            <a href="admin.php?category_update=<?php echo $category['category_id']; ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
            <a href="admin.php?category&category_delete=<?php echo $category['category_id']; ?>"><i class="fa fa-trash" aria-hidden="true"></i></a>
          </td>
        </tr>
     <?php endforeach; ?>
    </table>
    <br>

  <?php else: ?>
    <p>No categories found.</p>
  <?php endif; ?>

  <a class="btn btn-primary floatright" href="admin.php?category_create">Add new...</a>
