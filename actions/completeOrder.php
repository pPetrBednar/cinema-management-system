<?php

session_start();
$_SESSION['page'] == "reservations" || die("Ah, i see what you did there. No direct access next time!");

include_once '../includes/classes/User.php';
if (!empty($_SESSION['user'])) {
    $user = unserialize($_SESSION['user']);
    if ($user->permission != 0 && $user->permission != 10) {
        die("Ah, i see what you did there. No direct access next time!");
    }
} else {
    die("Ah, i see what you did there. No direct access next time!");
}

include_once '../includes/classes/Database.php';
include_once '../includes/classes/DatabaseManager.php';
include_once '../includes/classes/Seat.php';
include_once '../includes/classes/Reservation.php';
include_once '../includes/classes/Order.php';
include_once '../includes/classes/ProgramEntry.php';

$id = filter_input(INPUT_POST, 'id');

if ($id && $user) {
    $dbm = new DatabaseManager;

    try {
        $orderId = $dbm->completeOrder($id);
    } catch (ORDER_CONFIRMATION_FAILED_EXCEPTION $e) {
        $orderId = null;
    }
}

if ($orderId != null) {
    header("Location: ../completedOrder.php?id=" . $orderId);
} else {
    header("Location: ../" . $_SESSION['page'] . ".php");
}


