<?php

session_start();

$_SESSION['page'] == "hall" || die("Ah, i see what you did there. No direct access next time!");

include_once '../includes/classes/Database.php';
include_once '../includes/classes/DatabaseManager.php';
include_once '../includes/classes/User.php';
include_once '../includes/classes/Seat.php';

if (!empty($_SESSION['user'])) {
    $user = unserialize($_SESSION['user']);
    if ($user->permission != 0) {
        die("Ah, i see what you did there. No direct access next time!");
    }
} else {
    die("Ah, i see what you did there. No direct access next time!");
}

$hallId = $_SESSION["lastHall"];
$dbm = new DatabaseManager;
try {
    $seats = $dbm->getSeatsOfHall($hallId);
} catch (NO_DATA_FOUND_EXCEPTION $e) {
    $seats = null;
}

if ($seats != null) {
    echo json_encode($seats, JSON_PRETTY_PRINT);
}
        