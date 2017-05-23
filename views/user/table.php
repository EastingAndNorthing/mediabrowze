<h2>Users</h2>

<?php

global $userhandler; // Refer to this global variable, set in loader.php

if(isset($_GET['user_delete'])) {
  $update_msg = $userhandler->deleteUser($_GET['user_delete']);
}

if(isset($_GET['user_toggle_admin']) && isset($_GET['user_admin_status'])) {
  // Toggle the admin status status of a user
  $update_msg = $userhandler->toggleAdmin($_GET['user_toggle_admin'], $_GET['user_admin_status']);
}

if(isset($update_msg)) { echo "<p>$update_msg</p>"; }

$users = $userhandler->getUsers();

if(!empty($users)): ?>
  <table>
  <tr>
    <th>ID</th>
    <th>Username</th>
    <th>First name</th>
    <th>Last name</th>
    <th>Creation date</th>
    <th>Edit</th>
  </tr>
   <?php foreach($users as $user): ?>
      <tr>
        <td><?php echo $user['user_id']; ?></td>
        <td><?php echo $user['username']; ?></td>
        <td><?php echo $user['firstname']; ?></td>
        <td><?php echo $user['lastname']; ?></td>
        <td><?php echo $user['user_created_at']; ?></td>
        <td width="10%" class="editables">
          <?php if($user['is_admin']): ?>
            <a href="admin.php?user&user_toggle_admin=<?php echo $user['user_id']; ?>&user_admin_status=<?php echo $user['is_admin']; ?>"><i class="fa fa-user-plus" aria-hidden="true"></i></a>
          <?php else: ?>
            <a href="admin.php?user&user_toggle_admin=<?php echo $user['user_id']; ?>&user_admin_status=<?php echo $user['is_admin']; ?>"><i class="fa fa-user" aria-hidden="true"></i></a>
          <?php endif; ?>
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
