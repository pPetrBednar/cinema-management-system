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

$title = filter_input(INPUT_POST, 'title');
$city = filter_input(INPUT_POST, 'city');
$address = filter_input(INPUT_POST, 'address');
$coverUrl = filter_input(INPUT_POST, 'coverUrl');

if ($title) {
    $dbm = new DatabaseManager;
    try {
        $dbm->addCinema($title, $city, $address, $coverUrl);
    } catch (NO_DATA_ADDED_EXCEPTION $e) {
        // handle
    }
}

header("Location: ../" . $_SESSION['page'] . ".php");

