<?php
session_start();
$_SESSION['page'] = "index";

define('LOADER', true);
include_once 'includes/user.inc.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Responsive website</title>
  <meta charset="utf-8" />
  <link rel="stylesheet" href="css/style.css" />
</head>

<body>
  <?php
  include 'components/menu.comp.php';
  include 'components/gallery.comp.php';
  include 'components/footer.comp.php';
  ?>
</body>

</html>