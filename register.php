<?php
session_start();
$_SESSION['page'] = "register";

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
  if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['passwordAgain'])) {
    $dbm = new Dbm;

    try {
      $dbm->register($_POST['email'], $_POST['password'], $_POST['passwordAgain']);
      header("Location: ./");
    } catch (PASSWORDS_MISMATCH_EXCEPTION $e) {
      $state = $e->getMessage();
    } catch (REGISTRATION_FAILED_EXCEPTION $e) {
      $state = $e->getMessage();
    }
  }

  include 'components/menu.comp.php';
  include 'components/register.comp.php';
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