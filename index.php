<?php
session_start();
$_SESSION['page'] = "index";

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
        include 'includes/components/gallery.php';
        include 'includes/components/footer.php';
        ?>
    </body>

</html>