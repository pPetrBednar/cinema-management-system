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
          $dbm = new DatabaseManager;
          
         /* for ($i = 1; $i <= 100; $i++) {
              $dbm->register("user$i@gmail.com", "user$i", "user$i"); 
          }*/
          

        //$dbm = new DatabaseManager;
       /* $dbm->login("petrbednar51@gmail.com", "123456789");
        var_dump($_SESSION['user']);*/

        
        
        // $dbm->logout();
        ?>
        <?php
       /* $user = unserialize($_SESSION['user']);
        echo $user->email;*/
        ?>
    </body>

</html>