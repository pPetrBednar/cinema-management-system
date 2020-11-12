<?php
session_start();
$_SESSION['page'] = "account";

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
    include 'components/menu.comp.php';
    include 'components/account.comp.php';
    include 'components/footer.comp.php';
    ?>
</body>

</html>