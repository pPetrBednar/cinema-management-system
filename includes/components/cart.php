<?php
defined('LOADER') || die("Ah, i see what you did there. No direct access next time!");


include_once 'includes/classes/User.php';

if (!empty($_SESSION['user'])) {
    $user = unserialize($_SESSION['user']);

    include_once 'includes/classes/Database.php';
    include_once 'includes/classes/DatabaseManager.php';
    include_once 'includes/classes/Reservation.php';
    include_once 'includes/classes/Seat.php';
    include_once 'includes/classes/ProgramEntry.php';
    include_once 'includes/classes/Movie.php';
    include_once 'includes/classes/Hall.php';

    $dbm = new DatabaseManager;
    $reservations = null;
    ?>
    <section class="cart-container" id="cart">
        <div id="cart-sliding-box">
            <?php
            if (isset($_SESSION['reservations'])) {
                $reservations = unserialize($_SESSION['reservations']);

                foreach ($reservations as $reservation) {

                    try {
                        $programEntry = $dbm->getProgramEntry($reservation->programEntryId);
                    } catch (NO_DATA_FOUND_EXCEPTION $e) {
                        $programEntry = null;
                    }

                    if ($programEntry != null) {
                        ?>
                        <div class="cart-item">
                            <span onclick="window.open('movie.php?id=<?= $programEntry->movie->id; ?>', '_self')"><?= $programEntry->movie->title . " (" . $programEntry->movie->year . ")"; ?></span>
                            <span onclick="window.open('hall.php?id=<?= $programEntry->hall->id; ?>', '_self')">[<?= $programEntry->hall->uid; ?>]</span>
                            <span onclick="window.open('reservation.php?programEntry=<?= $programEntry->id; ?>', '_self')"><?= count($reservation->seats) . "x" ?></span>
                        </div>
                        <?php
                    }
                }
                ?>
                <div class="cart-controls">
                    <div>
                        <div onclick="window.open('./actions/discardOrder.php', '_self')">
                            Discard
                        </div>
                    </div>
                    <div>
                        <div onclick="window.open('checkout.php', '_self')">
                            Checkout
                        </div>
                    </div>
                </div>
                <?php
            } else {
                ?>
                No reservations
                <?php
            }
            ?>
        </div>
        <div class="cart-box" onclick="openCloseCart()" onmouseover="openCloseCartHover()" onmouseout="openCloseCartHover()">
            Cart
            <?= $reservations != null ? "<div>" . count($reservations) . "</div>" : ""; ?>
        </div>
    </section>
    <script type="text/javascript" src="js/cart.js"></script>
    <?php
}
?>

