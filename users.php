<?php
session_start();
$_SESSION['page'] = "users";

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
        include 'includes/components/users.php';
        include 'includes/components/footer.php';
        ?>
    </body>
</html>