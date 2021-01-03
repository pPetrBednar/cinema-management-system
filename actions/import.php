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

$seats = json_decode(file_get_contents($_FILES["file"]["tmp_name"]));

$hallId = $_SESSION["lastHall"];
$dbm = new DatabaseManager;
try {
    $seatsDb = $dbm->getSeatsOfHall($hallId);
} catch (NO_DATA_FOUND_EXCEPTION $e) {
    $seatsDb = null;
}

try {
    foreach ($seats as $seat) {

        $found = false;
        if ($seatsDb != null) {
            foreach ($seatsDb as $seatDb) {
                if ($seat->posX == $seatDb->posX && $seat->posY == $seatDb->posY) {
                    $found = true;
                    break;
                }
            }
        }

        if (!$found) {
            $dbm->addSeat($seat->posX, $seat->posY, $seat->type, $hallId);
        }
    }
} catch (Exception $e) {
    // Parse error
}

header("Location: ../" . $_SESSION['page'] . ".php?id=" . $_SESSION['lastHall']);

