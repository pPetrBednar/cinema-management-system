<?php
session_start();
include_once 'includes/classes/Database.php';
include_once 'includes/classes/DatabaseManager.php';
include_once 'includes/classes/User.php';
?>
<!DOCTYPE html>
<html>

    <head>

    </head>

    <body>
        <?php
        /*  $dbm = new Dbm;
          $dbm->register("petrbednar51@gmail.com", "123456789"); */

        $dbm = new DatabaseManager;
        $dbm->login("petrbednar51@gmail.com", "123456789");
        var_dump($_SESSION['user']);

        // $dbm->logout();
        ?>
        <?php
        $user = unserialize($_SESSION['user']);
        echo $user->email;
        ?>
    </body>

</html>