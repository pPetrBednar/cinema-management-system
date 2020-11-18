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

$posX = filter_input(INPUT_POST, 'posX');
$posY = filter_input(INPUT_POST, 'posY');
$type = filter_input(INPUT_POST, 'type');
$hallId = filter_input(INPUT_POST, 'hallId');

if ($posX && $posY && $hallId) {
    $dbm = new DatabaseManager;
    try {
        $dbm->addSeat($posX, $posY, $type, $hallId);
    } catch (NO_DATA_ADDED_EXCEPTION $e) {
        // handle
    }
}

header("Location: ../" . $_SESSION['page'] . ".php?id=" . $_SESSION['lastHall']);

