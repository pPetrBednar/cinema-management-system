<?php
session_start();
$_SESSION['page'] = "login";

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
        $state = " ";
        $email = filter_input(INPUT_POST, 'email');
        $password = filter_input(INPUT_POST, 'email');

        if ($email && $password) {
            $dbm = new DatabaseManager;

            try {
                $dbm->login($email, $password);
                header("Location: ./");
            } catch (USER_NOT_FOUND_EXCEPTION $e) {
                $state = $e->getMessage();
            } catch (WRONG_PASSWORD_EXCEPTION $e) {
                $state = $e->getMessage();
            }
        }

        include 'includes/components/menu.php';
        include 'includes/components/login.php';
        include 'includes/components/footer.php';

        if ($state != " ") {
            ?>
            <script type="text/javascript">
                window.onload = (e) => {
                    alert("<?= $state ?>");
                };
            </script>
            <?php
        }
        ?>
    </body>

</html>