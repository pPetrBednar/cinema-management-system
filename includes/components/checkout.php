<?php
defined('LOADER') || die("Ah, i see what you did there. No direct access next time!");

include_once 'includes/classes/Database.php';
include_once 'includes/classes/DatabaseManager.php';
include_once 'includes/classes/User.php';
include_once 'includes/classes/Cinema.php';
include_once 'includes/classes/Hall.php';
include_once 'includes/classes/Seat.php';
include_once 'includes/classes/ProgramEntry.php';
include_once 'includes/classes/Reservation.php';

$dbm = new DatabaseManager;

if (!empty($_SESSION['user'])) {
    $user = unserialize($_SESSION['user']);

    if (isset($_SESSION['reservations'])) {
        $reservations = unserialize($_SESSION['reservations']);

        $tickets = 0;
        $sumPrice = 0;
        ?>
        <section class="checkout-container" id="checkout">
            <div class="checkout-box">
                <div>Order summary:</div>
                <div>
                    <table>
                        <tr>
                            <th>Cinema</th>
                            <th>Hall</th>
                            <th>Movie</th>
                            <th>Seats</th>
                        </tr>
                        <?php
                        foreach ($reservations as $reservation) {

                            try {
                                $programEntry = $dbm->getProgramEntry($reservation->programEntryId);
                            } catch (NO_DATA_FOUND_EXCEPTION $e) {
                                $programEntry = null;
                            }

                            if ($programEntry != null) {

                                try {
                                    $cinema = $dbm->getCinema($programEntry->hall->cinemaId);
                                } catch (NO_DATA_FOUND_EXCEPTION $e) {
                                    $cinema = null;
                                }
                                if ($cinema != null) {
                                    $tickets += count($reservation->seats);
                                    $sumPrice += count($reservation->seats) * $programEntry->price;
                                    ?>
                                    <tr>
                                        <td>
                                            <span onclick="window.open('cinema.php?id=<?= $cinema->id; ?>', '_self')"><?= $cinema->title . " (" . $cinema->city . ")"; ?></span>
                                        </td>
                                        <td>
                                            <span onclick="window.open('hall.php?id=<?= $programEntry->hall->id; ?>', '_self')"><?= $programEntry->hall->uid . " (" . $programEntry->hall->type . ")"; ?></span>
                                        </td>
                                        <td>
                                            <span onclick="window.open('movie.php?id=<?= $programEntry->movie->id; ?>', '_self')"><?= $programEntry->movie->title . " (" . $programEntry->movie->year . ")"; ?></span>
                                        </td>
                                        <td>
                                            <span onclick="window.open('reservation.php?programEntry=<?= $programEntry->id; ?>', '_self')"><?= count($reservation->seats) . "x"; ?></span>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                        }
                        ?>
                    </table>
                </div>
                <div>
                    Price summary:
                </div>
                <div>
                    <table>
                        <tr>
                            <th>Total tickets</th>
                            <th>Total price</th>
                        </tr>
                        <tr>
                            <td><?= $tickets; ?></td>
                            <td><?= $sumPrice; ?> CZK</td>
                        </tr>
                    </table>
                </div>
                <div>
                    <div>
                        <div onclick="window.open('./actions/discardOrder.php', '_self')">Discard</div>
                    </div>
                    <div>
                        <div onclick="window.open('./actions/confirmOrder.php', '_self')">Confirm</div>
                    </div>
                </div>
            </div>
        </section>
        <?php
    }
} else {
    header('Location: ./');
}
?>

