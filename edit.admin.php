<?php

session_start();

if ($_SESSION['page'] != "users.admin" && $_SESSION['page'] != "account") {
    die("Ah, i see what you did there. No direct access next time!");
}

include_once 'includes/classes/Database.php';
include_once 'includes/classes/DatabaseManager.php';
include_once 'includes/classes/User.php';

if (filter_input(INPUT_POST, 'action') && !empty(filter_input(INPUT_POST, 'action'))) {
    $dbm = new DatabaseManager;
    $user = unserialize($_SESSION['user']);
    switch (filter_input(INPUT_POST, 'action')) {
        case "editUserAdmin":
            if ($user->permission == 0 && filter_input(INPUT_POST, 'email') != $user->email) {
                $dbm->editUserAdmin(filter_input(INPUT_POST, 'email'), filter_input(INPUT_POST, 'firstName'), filter_input(INPUT_POST, 'lastName'), filter_input(INPUT_POST, 'permission'));
            }
            break;
        case "deleteUser":
            if ($user->permission == 0 && filter_input(INPUT_POST, 'email') != $user->email) {
                $dbm->deleteUser(filter_input(INPUT_POST, 'email'));
            }
            break;
        case "editUser":
            $dbm->editUser($user->email, filter_input(INPUT_POST, 'firstName'), filter_input(INPUT_POST, 'lastName'));
            $user->firstName = filter_input(INPUT_POST, 'firstName');
            $user->lastName = filter_input(INPUT_POST, 'lastName');
            $_SESSION['user'] = serialize($user);
            break;
    }
}

header("Location: " . $_SESSION['page'] . ".php");
