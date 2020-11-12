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
  <?php
  include 'components/head.comp.php';
  ?>
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

      foreach ($users as $res) {
        if ($user->email == $res->email) {
          continue;
        }
      ?>
        <tr>
          <form action="edit.admin.php" method="post">
            <td><input type="text" name="email" value="<?= $res->email; ?>"></td>
            <td><input type="text" name="firstName" value="<?= $res->firstName; ?>"></td>
            <td><input type="text" name="lastName" value="<?= $res->lastName; ?>"></td>
            <td><input type="text" name="permission" value="<?= $res->permission; ?>"></td>
            <td><?= $res->registered; ?></td>
            <td>
              <input type="text" name="action" value="editUserAdmin" style="display: none;">
              <button type="submit">Edit</button>
            </td>
          </form>
          <td>
            <form action="edit.admin.php" method="post">
              <input type="text" name="action" value="deleteUser" style="display: none;">
              <input type="text" name="email" value="<?= $res->email; ?>" style="display: none;">
              <button type="submit">Delete</button>
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