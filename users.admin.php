<?php
session_start();
$_SESSION['page'] = "users.admin";

define('LOADER', true);
include_once 'includes/db.inc.php';
include_once 'includes/dbm.inc.php';
include_once 'includes/user.inc.php';

if (isset($_SESSION['user']) && !empty($_SESSION['user'])) {
  $user = unserialize($_SESSION['user']);
  if ($user->permission != 0) {
    exit;
  }
} else {
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Responsive website</title>
  <meta charset="utf-8" />
  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="css/admin.css" />
</head>

<body>
  <?php
  include 'components/menu.comp.php';
  ?>
  <div class="users-admin-container">
    <table>
      <tr>
        <th>Email</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Permission</th>
        <th>Registered</th>
        <th>Action edit</th>
        <th>Action delete</th>
      </tr>
      <?php
      $dbm = new Dbm;
      $users = $dbm->getAllUsers();

      foreach ($users as $user) {
      ?>
        <tr>
          <td><?= $user->email; ?></td>
          <td><?= $user->firstname; ?></td>
          <td><?= $user->lastname; ?></td>
          <td><?= $user->permission; ?></td>
          <td><?= $user->registered; ?></td>
          <td>
            <form action="editor.php" method="post">
              <input type="text" name="action" value="editUserAdmin" style="display: none;">
              <input type="text" name="email" value="<?= $user->email; ?>" style="display: none;">
              <input type="submit" value="Edit">
            </form>
          </td>
          <td>
            <form action="editor.php" method="post">
              <input type="text" name="action" value="deleteUser" style="display: none;">
              <input type="text" name="email" value="<?= $user->email; ?>" style="display: none;">
              <input type="submit" value="Delete">
            </form>
          </td>
        </tr>
      <?php
      }
      ?>
    </table>
  </div>
  <?php

  include 'components/footer.comp.php';
  ?>
</body>

</html>