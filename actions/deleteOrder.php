<?php

session_start();
$_SESSION['page'] == "orders" || die("Ah, i see what you did there. No direct access next time!");

if (empty($_SESSION['user'])) {
    die("Ah, i see what you did there. No direct access next time!");
}

include_once '../includes/classes/Database.php';
include_once '../includes/classes/DatabaseManager.php';

$dbm = new DatabaseManager;
$id = filter_input(INPUT_POST, 'id');

if ($id) {
    try {
        $dbm->deleteOrder($id);
    } catch (NO_DATA_DELETED_EXCEPTION $e) {
        
    }
}

header("Location: ../orders.php");
