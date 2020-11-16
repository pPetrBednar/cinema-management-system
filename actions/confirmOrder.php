<?php

session_start();
$_SESSION['page'] == "checkout" || die("Ah, i see what you did there. No direct access next time!");

if (empty($_SESSION['user'])) {
    die("Ah, i see what you did there. No direct access next time!");
}

include_once '../includes/classes/Database.php';
include_once '../includes/classes/DatabaseManager.php';
include_once '../includes/classes/User.php';
include_once '../includes/classes/Seat.php';
include_once '../includes/classes/Reservation.php';
include_once '../includes/classes/ProgramEntry.php';

if (isset($_SESSION['reservations']) && !empty($_SESSION['reservations'])) {

    $reservations = unserialize($_SESSION['reservations']);
    $user = unserialize($_SESSION['user']);
    $dbm = new DatabaseManager;

    try {
        $dbm->addOrder($reservations, $user);
        unset($_SESSION['reservations']);
    } catch (NO_DATA_ADDED_EXCEPTION $e) {
        
    } catch (RESERVATION_FAILED_EXCEPTION $e) {
        
    }
}

header("Location: ../orders.php");
