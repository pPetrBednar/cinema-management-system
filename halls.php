<?php
session_start();
$_SESSION['page'] = "halls";

define('LOADER', true);
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
        include 'includes/components/cart.php';
        include 'includes/components/halls.php';
        include 'includes/components/footer.php';
        ?>
    </body>
</html>

