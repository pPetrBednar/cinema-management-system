<?php
defined('LOADER') || die("Ah, i see what you did there. No direct access next time!");

include_once 'includes/classes/Database.php';
include_once 'includes/classes/DatabaseManager.php';
include_once 'includes/classes/User.php';
include_once 'includes/classes/Hall.php';
include_once 'includes/classes/Seat.php';
include_once 'includes/classes/ProgramEntry.php';
include_once 'includes/classes/Reservation.php';

$dbm = new DatabaseManager;
$programEntryId = filter_input(INPUT_GET, 'programEntry');

if (!empty($_SESSION['user'])) {
    $user = unserialize($_SESSION['user']);
} else {
    $user = null;
}

if ($programEntryId) {
    $_SESSION['lastProgramEntry'] = $programEntryId;

    try {
        $programEntry = $dbm->getProgramEntryNoData($programEntryId);
    } catch (NO_DATA_FOUND_EXCEPTION $e) {
        $programEntry = null;
    }

    if ($programEntry != null) {
        try {
            $hall = $dbm->getHall($programEntry->hall);
        } catch (NO_DATA_FOUND_EXCEPTION $e) {
            $hall = null;
        }

        try {
            $occupiedSeats = $dbm->getOccupiedSeatsOfProgramEntry($programEntry->id);
        } catch (NO_DATA_FOUND_EXCEPTION $e) {
            $occupiedSeats = null;
        }
    }
}

if ($programEntry != null) {
    if ($hall != null) {
        ?>
        <div class="hall-container">
            <div class="hall-seats">
                <div><span>Seat reservation:</span><br> Cinema Hall <?= $hall->uid . " (" . $hall->type . ")" ?></div>
                <div>Screen</div>
                <table>
                    <?php
                    try {
                        $seats = $dbm->getSeatsOfHall($hall->id);
                    } catch (NO_DATA_FOUND_EXCEPTION $e) {
                        $seats = null;
                    }

                    if ($seats != null) {

                        /*
                         * HELLO DARKNESS MY OLD FRIEND
                         */
                        $maxX = 0;
                        $maxY = 0;
                        foreach ($seats as $seat) {
                            if ($seat->posX > $maxX) {
                                $maxX = $seat->posX;
                            }

                            if ($seat->posY > $maxY) {
                                $maxY = $seat->posY;
                            }
                        }

                        $arr = new SplFixedArray($maxY);
                        for ($i = 0; $i < $maxY; $i++) {
                            $arr[$i] = new SplFixedArray($maxX);
                        }

                        foreach ($seats as $seat) {
                            $arr[$seat->posY - 1][$seat->posX - 1] = $seat;
                        }

                        if ($occupiedSeats != null) {
                            foreach ($occupiedSeats as $seat) {
                                $arr[$seat->posY - 1][$seat->posX - 1] = "occupied";
                            }
                        }

                        if (isset($_SESSION['reservations']) && $_SESSION['reservations'] != null) {
                            $reservations = unserialize($_SESSION['reservations']);
                            foreach ($reservations as $reservation) {
                                if ($reservation->programEntryId == $programEntry->id) {
                                    foreach ($reservation->seats as $seat) {
                                        $arr[$seat->posY - 1][$seat->posX - 1] = "selected";
                                    }
                                }
                            }
                        }

                        for ($y = 0; $y < $maxY; $y++) {
                            ?>
                            <tr>
                                <?php
                                for ($x = 0; $x < $maxX; $x++) {
                                    if ($arr[$y][$x] != null) {
                                        if ($arr[$y][$x] == "occupied") {
                                            ?>
                                            <td class="hall-seat-occupied"></td>
                                            <?php
                                        } else if ($arr[$y][$x] == "selected") {
                                            ?>
                                            <td class="hall-seat-selected  hall-seat-reserve">
                                                <form action="./actions/selectSeat.php" method="post">
                                                    <input type="number" name="programEntryId" value="<?= $programEntry->id; ?>" style="display: none;" >
                                                    <input type="number" name="posX" value="<?= $x + 1; ?>" style="display: none;" >
                                                    <input type="number" name="posY" value="<?= $y + 1; ?>" style="display: none;" >
                                                    <button type="submit"></button>
                                                </form>
                                            </td>
                                            <?php
                                        } else {
                                            if ($user != null) {
                                                ?>
                                                <td class="hall-seat-empty hall-seat-reserve">
                                                    <form action="./actions/selectSeat.php" method="post">
                                                        <input type="number" name="programEntryId" value="<?= $programEntry->id; ?>" style="display: none;" >
                                                        <input type="number" name="posX" value="<?= $x + 1; ?>" style="display: none;" >
                                                        <input type="number" name="posY" value="<?= $y + 1; ?>" style="display: none;" >
                                                        <button type="submit"></button>
                                                    </form>
                                                </td>
                                                <?php
                                            } else {
                                                ?>
                                                <td class="hall-seat-empty" onclick="alert('Login to reserve')"></td>
                                                <?php
                                            }
                                        }
                                    } else {
                                        ?>
                                        <td class="hall-seat-none"></td>
                                        <?php
                                    }
                                }
                                ?>
                            </tr>
                            <?php
                        }
                        /*
                         * /HELLO DARKNESS MY OLD FRIEND
                         */
                    }
                    ?>
                </table>
            </div>
        </div>
        <?php
    }
}
?>

