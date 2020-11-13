<?php
session_start();
$_SESSION['page'] = "account";

define('LOADER', true);
include_once 'includes/classes/Database.php';
include_once 'includes/classes/DatabaseManager.php';
include_once 'includes/classes/User.php';
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <?php
        include 'includes/components/head.php';
        ?>
    </head>

    <body>
        <?php
        include 'includes/components/menu.php';
        include 'includes/components/account.php';
        include 'includes/components/footer.php';
        ?>
    </body>

</html>