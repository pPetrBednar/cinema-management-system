<?php

session_start();
$_SESSION['page'] == "users" || die("Ah, i see what you did there. No direct access next time!");

include_once '../includes/classes/Database.php';
include_once '../includes/classes/DatabaseManager.php';
include_once '../includes/classes/User.php';

if (!empty($_SESSION['user'])) {
    $user = unserialize($_SESSION['user']);
    if ($user->permission != 0) {
        die("Ah, i see what you did there. No direct access next time!");
    }
} else {
    die("Ah, i see what you did there. No direct access next time!");
}

$id = filter_input(INPUT_POST, 'id');
$email = filter_input(INPUT_POST, 'email');
$firstName = filter_input(INPUT_POST, 'firstName');
$lastName = filter_input(INPUT_POST, 'lastName');
$permission = filter_input(INPUT_POST, 'permission');

if ($id && $email && $firstName && $lastName && $permission) {
    $dbm = new DatabaseManager;
    try {
        $dbm->editUser($id, $email, $firstName, $lastName, $permission);
    } catch (NO_DATA_ADDED_EXCEPTION $e) {
        // handle
    }
}

header("Location: ../" . $_SESSION['page'] . ".php");

