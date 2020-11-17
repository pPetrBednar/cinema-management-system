<?php

session_start();
$_SESSION['page'] == "account" || die("Ah, i see what you did there. No direct access next time!");

include_once '../includes/classes/Database.php';
include_once '../includes/classes/DatabaseManager.php';
include_once '../includes/classes/User.php';

if (!empty($_SESSION['user'])) {
    $user = unserialize($_SESSION['user']);

    $password = filter_input(INPUT_POST, 'password');
    $passwordAgain = filter_input(INPUT_POST, 'passwordAgain');

    if ($password && $passwordAgain) {
        $dbm = new DatabaseManager;
        try {
            $dbm->changePassword($user, $password, $passwordAgain);
        } catch (PASSWORDS_MISMATCH_EXCEPTION $e) {
            
        }
    }
} else {
    die("Ah, i see what you did there. No direct access next time!");
}

header("Location: ../" . $_SESSION['page'] . ".php");

