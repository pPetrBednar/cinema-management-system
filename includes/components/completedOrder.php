<?php
defined('LOADER') || die("Ah, i see what you did there. No direct access next time!");

include_once 'includes/classes/Database.php';
include_once 'includes/classes/DatabaseManager.php';
include_once 'includes/classes/User.php';
include_once 'includes/classes/Cinema.php';
include_once 'includes/classes/Hall.php';
include_once 'includes/classes/Seat.php';
include_once 'includes/classes/ProgramEntry.php';
include_once 'includes/classes/CompletedReservation.php';
include_once 'includes/classes/CompletedOrder.php';

$dbm = new DatabaseManager;

if (!empty($_SESSION['user'])) {
    $user = unserialize($_SESSION['user']);

    if ($user->permission == 0 || $user->permission == 10) {

        $id = filter_input(INPUT_GET, 'id');
        $alphabet = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z');
        if ($id) {
            try {
                $order = $dbm->getCompletedOrder($id);
            } catch (NO_DATA_FOUND_EXCEPTION $e) {
                $order = null;
            }
            ?>
            <section class="orders-container" id="complete-order">
                <h2 class="display-none">Complete order</h2>
                <div class="orders-box">
                    <div>Completed order:  <?= $order == null ? "&nbsp;&nbsp;&nbsp;Order not found" : ""; ?></div>
                    <div class="orders-list">
                        <?php
                        if ($order != null) {

                            try {
                                $reservations = $dbm->getReservationsOfCompletedOrder($order->id);
                            } catch (NO_DATA_FOUND_EXCEPTION $e) {
                                $reservations = null;
                            }

                            if ($reservations != null) {
                                $tickets = 0;
                                $sumPrice = 0;
                                $date = DateTime::createFromFormat("Y-m-d H:i:s", $order->completed);
                                ?>
                                <div class="orders-item">
                                    <div>
                                        <div>Order id: <?= $order->id; ?></div>
                                        <div><?= $date->format("H:i d. m. Y"); ?></div>
                                    </div>
                                    <table>
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
                                                    $tickets += $reservation->seats;
                                                    $sumPrice += $reservation->price;

                                                    try {
                                                        $seats = $dbm->getSeatsOfCompletedReservation($reservation->id);
                                                    } catch (NO_DATA_FOUND_EXCEPTION $e) {
                                                        $seats = null;
                                                    }

                                                    if ($seats != null) {
                                                        foreach ($seats as $seat) {
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
                                                                    <span onclick="window.open('reservation.php?programEntry=<?= $programEntry->id; ?>', '_self')"><?= strtoupper($alphabet[$seat->posY - 1]) . $seat->posX; ?></span>
                                                                </td>
                                                            </tr>
                                                            <?php
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                        ?>
                                    </table>
                                    <div>
                                        <div>
                                            Paid price: <?= $sumPrice; ?> CZK
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </section>
            <?php
        } else {
            ?>
            <section class="orders-container" id="complete-order">
                <h2 class="display-none">Complete order</h2>
                <div class="orders-dialog">
                    <input id="order-search" type="number" name="id" placeholder="Completed order id">
                    <div onclick="window.open('completedOrder.php?id=' + document.getElementById('order-search').value, '_self')">Search</div>
                </div>
            </section>
            <?php
        }
    } else {
        header('Location: ./');
    }
} else {
    header('Location: ./');
}
?>

