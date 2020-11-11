<?php
session_start();
$_SESSION['page'] = "login";

include_once 'includes/db.inc.php';
include_once 'includes/dbm.inc.php';

$dbm = new Dbm;
$dbm->logout();

header('Location: ./');
exit;
