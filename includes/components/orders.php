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
include_once 'includes/classes/Order.php';

$dbm = new DatabaseManager;

if (!empty($_SESSION['user'])) {
    $user = unserialize($_SESSION['user']);

    try {
        $orders = $dbm->getActiveOrdersOfUser($user->id);
    } catch (NO_DATA_FOUND_EXCEPTION $e) {
        $orders = null;
    }
    ?>
    <section class="orders-container" id="orders">
        <div class="orders-box">
            <div>Active orders:  <?= $orders == null ? "&nbsp;&nbsp;&nbsp;No orders" : ""; ?></div>
            <div class="orders-list">
                <?php
                if ($orders != null) {
                    foreach ($orders as $order) {

                        try {
                            $reservations = $dbm->getReservationsOfOrder($order->id);
                        } catch (NO_DATA_FOUND_EXCEPTION $e) {
                            $reservations = null;
                        }

                        if ($reservations != null) {

                            $tickets = 0;
                            $sumPrice = 0;
                            $date = DateTime::createFromFormat("Y-m-d H:i:s", $order->created);
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
                                                $sumPrice += $reservation->seats * $programEntry->price;
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
                                                        <span onclick="window.open('reservation.php?programEntry=<?= $programEntry->id; ?>', '_self')"><?= $reservation->seats . "x"; ?></span>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                    }
                                    ?>
                                </table>
                                <div>
                                    <div>
                                        Total price: <?= $sumPrice; ?> CZK
                                    </div>
                                    <div>
                                        <form action="./actions/deleteOrder.php" method="post">
                                            <input type="number" name="id" value="<?= $order->id; ?>" style="display: none;">
                                            <button type="submit">Cancel</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    }
                }
                ?>
            </div>
        </div>
    </section>
    <?php
} else {
    header('Location: ./');
}
?>

