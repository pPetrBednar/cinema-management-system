<?php
session_start();
$_SESSION['page'] = "reservations";

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
        include 'includes/components/reservations.php';
        include 'includes/components/footer.php';
        ?>
    </body>
</html>


