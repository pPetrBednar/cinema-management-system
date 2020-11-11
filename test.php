<?php
session_start();
include_once 'includes/db.inc.php';
include_once 'includes/dbm.inc.php';
include_once 'includes/user.inc.php';
?>
<!DOCTYPE html>
<html>

<head>

</head>

<body>
    <?php
    /*  $dbm = new Dbm;
           $dbm->register("petrbednar51@gmail.com", "123456789");*/

    $dbm = new Dbm;
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