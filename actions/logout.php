<?php

session_start();
$_SESSION['page'] = "login";

include_once '../includes/classes/Database.php';
include_once '../includes/classes/DatabaseManager.php';

$dbm = new DatabaseManager;
$dbm->logout();

header('Location: ../');
