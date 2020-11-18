<?php

session_start();
$_SESSION['page'] == "hall" || die("Ah, i see what you did there. No direct access next time!");

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
$uid = filter_input(INPUT_POST, 'uid');
$type = filter_input(INPUT_POST, 'type');

if ($id && $uid) {
    $dbm = new DatabaseManager;
    try {
        $dbm->editHall($id, $uid, $type);
    } catch (NO_DATA_ADDED_EXCEPTION $e) {
        // handle
    }
}

header("Location: ../" . $_SESSION['page'] . ".php?id=" . $_SESSION['lastHall']);

