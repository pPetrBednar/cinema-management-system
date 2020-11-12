<?php
session_start();

if ($_SESSION['page'] != "users.admin" && $_SESSION['page'] != "account") {
    die("Ah, i see what you did there. No direct access next time!");
}

include_once 'includes/db.inc.php';
include_once 'includes/dbm.inc.php';
include_once 'includes/user.inc.php';

if (isset($_POST['action']) && !empty($_POST['action'])) {
    $dbm = new Dbm;
    $user = unserialize($_SESSION['user']);
    switch ($_POST['action']) {
        case "editUserAdmin":
            if ($user->permission == 0 && $_POST['email'] != $user->email) {
                $dbm->editUserAdmin($_POST['email'], $_POST['firstName'], $_POST['lastName'], $_POST['permission']);
            }
            break;
        case "deleteUser":
            if ($user->permission == 0 && $_POST['email'] != $user->email) {
                $dbm->deleteUser($_POST['email']);
            }
            break;
        case "editUser":
            $dbm->editUser($user->email, $_POST['firstName'], $_POST['lastName']);
            $user->firstName = $_POST['firstName'];
            $user->lastName = $_POST['lastName'];
            $_SESSION['user'] = serialize($user);
            break;
    }
}

header("Location: " . $_SESSION['page'] . ".php");
