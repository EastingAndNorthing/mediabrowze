<h2>Users</h2>

<?php

  global $userhandler; // Refer to this global variable, set in loader.php

  if(isset($_GET['user_delete'])) {
    $delete_msg = $userhandler->deleteUser($_GET['user_delete']);
  }

  if(isset($delete_msg)) { echo "<p>$delete_msg</p>"; }

  $users = $userhandler->getUsers();

  if(!empty($users)): ?>
    <table>
    <tr>
      <th>ID</th>
      <th>Username</th>
      <th>First name</th>
      <th>Last name</th>
      <th>Edit</th>
    </tr>
     <?php foreach($users as $user): ?>
        <tr>
          <td><?php echo $user['user_id']; ?></td>
          <td><?php echo $user['username']; ?></td>
          <td><?php echo $user['firstname']; ?></td>
          <td><?php echo $user['lastname']; ?></td>
          <td width="10%" class="editables">
            <a href="admin.php?user_update=<?php echo $user['user_id']; ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
            <a href="admin.php?user&user_delete=<?php echo $user['user_id']; ?>"><i class="fa fa-trash" aria-hidden="true"></i></a>
          </td>
        </tr>
     <?php endforeach; ?>
    </table>
    <br>

  <?php else: ?>
    <p>No users found.</p>
  <?php endif; ?>

  <a class="btn btn-primary floatright" href="register.php">Add new...</a>
