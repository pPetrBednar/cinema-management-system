<?php

session_start();
$_SESSION['page'] == "cinema" || die("Ah, i see what you did there. No direct access next time!");

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

$start = filter_input(INPUT_POST, 'start');
$price = filter_input(INPUT_POST, 'price');
$movieId = filter_input(INPUT_POST, 'movies');
$hallId = filter_input(INPUT_POST, 'halls');

if ($start && $price && $movieId && $hallId) {
    $dbm = new DatabaseManager;
    try {
        $dbm->addProgramEntry($start, $price, $movieId, $hallId);
    } catch (NO_DATA_ADDED_EXCEPTION $e) {
        // handle
    }
}

header("Location: ../" . $_SESSION['page'] . ".php?id=" . $_SESSION['lastCinema']);

