<?php
session_start();
$_SESSION['page'] = "index";

define('LOADER', true);
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
  include 'components/menu.comp.php';
  include 'components/gallery.comp.php';
  include 'components/footer.comp.php';
  ?>
</body>

</html>