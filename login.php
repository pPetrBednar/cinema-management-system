<?php
session_start();
$_SESSION['page'] = "login";

define('LOADER', true);
include_once 'includes/db.inc.php';
include_once 'includes/dbm.inc.php';
include_once 'includes/user.inc.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  include 'components/head.comp.php';
  ?>
</head>

<body>
  <?php

  $state = " ";
  if (isset($_POST['email']) && isset($_POST['password'])) {
    $dbm = new Dbm;

    try {
      $dbm->login($_POST['email'], $_POST['password']);
      header("Location: ./");
    } catch (USER_NOT_FOUND_EXCEPTION $e) {
      $state = $e->getMessage();
    } catch (WRONG_PASSWORD_EXCEPTION $e) {
      $state = $e->getMessage();
    }
  }

  include 'components/menu.comp.php';
  include 'components/login.comp.php';
  include 'components/footer.comp.php';

  if ($state != " ") {
  ?>
    <script type="text/javascript">
      window.onload = (e) => {
        alert("<?= $state ?>");
      }
    </script>
  <?php
  }
  ?>
</body>

</html>