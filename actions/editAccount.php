<?php

session_start();
$_SESSION['page'] == "account" || die("Ah, i see what you did there. No direct access next time!");

include_once '../includes/classes/Database.php';
include_once '../includes/classes/DatabaseManager.php';
include_once '../includes/classes/User.php';

if (!empty($_SESSION['user'])) {
    $user = unserialize($_SESSION['user']);
} else {
    die("Ah, i see what you did there. No direct access next time!");
}

$firstName = filter_input(INPUT_POST, 'firstName');
$lastName = filter_input(INPUT_POST, 'lastName');

if ($user && $firstName && $lastName) {
    $dbm = new DatabaseManager;
    try {
        $dbm->editAccount($user->id, $firstName, $lastName);
        $user->firstName = $firstName;
        $user->lastName = $lastName;
        $_SESSION['user'] = serialize($user);
    } catch (NO_DATA_ADDED_EXCEPTION $e) {
        // handle
    }
}

header("Location: ../" . $_SESSION['page'] . ".php");

