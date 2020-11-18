<?php

session_start();
$_SESSION['page'] == "cinemas" || die("Ah, i see what you did there. No direct access next time!");

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

if ($id) {
    $dbm = new DatabaseManager;
    try {
        $dbm->deleteCinema($id);
    } catch (NO_DATA_ADDED_EXCEPTION $e) {
        // handle
    }
}

header("Location: ../" . $_SESSION['page'] . ".php");

