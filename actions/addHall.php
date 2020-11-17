<?php

session_start();
$_SESSION['page'] == "halls" || die("Ah, i see what you did there. No direct access next time!");

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

$uid = filter_input(INPUT_POST, 'uid');
$type = filter_input(INPUT_POST, 'type');
$cinemaId = filter_input(INPUT_POST, 'cinemaId');

if ($uid && $type && $cinemaId) {
    $dbm = new DatabaseManager;
    try {
        $dbm->addHall($uid, $type, $cinemaId);
    } catch (NO_DATA_ADDED_EXCEPTION $e) {
        // handle
    }
}

header("Location: ../" . $_SESSION['page'] . ".php?cinema=" . $_SESSION['lastCinema']);

