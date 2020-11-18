<?php
session_start();
$_SESSION['page'] = "register";

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
        $password = filter_input(INPUT_POST, 'password');
        $passwordAgain = filter_input(INPUT_POST, 'passwordAgain');

        if ($email && $password && $passwordAgain) {
            $dbm = new DatabaseManager;

            try {
                $dbm->register($email, $password, $passwordAgain);
                header("Location: ./");
            } catch (PASSWORDS_MISMATCH_EXCEPTION $e) {
                $state = $e->getMessage();
            } catch (REGISTRATION_FAILED_EXCEPTION $e) {
                $state = $e->getMessage();
            }
        }

        include 'includes/components/menu.php';
        include 'includes/components/register.php';
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