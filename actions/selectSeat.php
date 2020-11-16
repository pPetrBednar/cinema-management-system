<?php

session_start();
$_SESSION['page'] == "reservation" || die("Ah, i see what you did there. No direct access next time!");

if (empty($_SESSION['user'])) {
    die("Ah, i see what you did there. No direct access next time!");
}

include_once '../includes/classes/Seat.php';
include_once '../includes/classes/Reservation.php';

$programEntryId = filter_input(INPUT_POST, 'programEntryId');
$posX = filter_input(INPUT_POST, 'posX');
$posY = filter_input(INPUT_POST, 'posY');

if ($programEntryId && $posX && $posY) {

    if (isset($_SESSION['reservations']) && $_SESSION['reservations'] != null) {
        //echo "this\n";
        $reservations = unserialize($_SESSION['reservations']);
        $found = false;

        foreach ($reservations as $kr => $reservation) {
            if ($reservation->programEntryId == $programEntryId) {
                foreach ($reservation->seats as $ks => $seat) {
                    if ($seat->posX == $posX && $seat->posY == $posY) {
                        unset($reservations[$kr]->seats[$ks]);
                        if (empty($reservation->seats)) {
                            unset($reservations[$kr]);
                        }

                        if (empty($reservations)) {
                            unset($_SESSION['reservations']);
                            $found = true;
                            //echo "this1\n";
                            break 2;
                        }

                        $_SESSION['reservations'] = serialize($reservations);
                        $found = true;
                        //echo "this2\n";
                        break 2;
                    }
                }

                array_push($reservation->seats, new Seat("", $posX, $posY, "", ""));
                $_SESSION['reservations'] = serialize($reservations);
                $found = true;
                //echo "this3\n";
                break 1;
            }
        }

        if (!$found) {
            array_push($reservations, new Reservation("", $programEntryId, array(new Seat("", $posX, $posY, "", ""))));
            $_SESSION['reservations'] = serialize($reservations);
            //echo "this4\n";
        }
    } else {
        $reservations = array();
        array_push($reservations, new Reservation("", $programEntryId, array(new Seat("", $posX, $posY, "", ""))));
        $_SESSION['reservations'] = serialize($reservations);
    }
}

header("Location: ../" . $_SESSION['page'] . ".php?programEntry=" . $_SESSION['lastProgramEntry']);

