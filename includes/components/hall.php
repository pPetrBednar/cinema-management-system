<?php
defined('LOADER') || die("Ah, i see what you did there. No direct access next time!");

include_once 'includes/classes/Database.php';
include_once 'includes/classes/DatabaseManager.php';
include_once 'includes/classes/User.php';
include_once 'includes/classes/Hall.php';
include_once 'includes/classes/Seat.php';

$dbm = new DatabaseManager;
$id = filter_input(INPUT_GET, 'id');

if ($id) {
    $_SESSION['lastHall'] = $id;
    try {
        $hall = $dbm->getHall($id);
    } catch (NO_DATA_FOUND_EXCEPTION $e) {
        $hall = null;
    }
}

if ($hall != null) {
    ?>
    <section class="hall-container" id="hall">
        <div class="hall-box">
            <div>
                <div>
                    <img src="img/placeholder-image.png" />
                </div>
            </div>
            <div>
                <div><?= $hall->uid; ?></div>
                <div><span>Type:</span><br><?= $hall->type; ?></div>
            </div>
        </div>
        <div class="hall-seats">
            <div>Seats:</div>
            <div>Screen</div>
            <table>
                <?php
                if (!empty($_SESSION['user'])) {
                    $user = unserialize($_SESSION['user']);
                } else {
                    $user = null;
                }

                try {
                    $seats = $dbm->getSeatsOfHall($id);
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

                    for ($y = 0; $y < $maxY; $y++) {
                        ?>
                        <tr>
                            <?php
                            for ($x = 0; $x < $maxX; $x++) {
                                if ($arr[$y][$x] != null) {
                                    if ($user != null && $user->permission == 0) {
                                        ?>
                                        <td class="hall-seat-empty">
                                            <form action="./actions/deleteSeat.php" method="post">
                                                <input type="number" name="id" value="<?= $arr[$y][$x]->id; ?>" style="display: none;">
                                                <button type="submit">x</button>
                                            </form>
                                        </td>
                                        <?php
                                    } else {
                                        ?>
                                        <td class="hall-seat-empty"></td>
                                        <?php
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
    </section>
    <?php
}

if ($user != null) {
    if ($user->permission == 0) {
        ?>
        <section class="halls-add" onclick="openDialog();">
            Edit hall
        </section>
        <section class="halls-add-dialog-container" id="halls-add-dialog">
            <form action="./actions/editHall.php" method="post">
                <div class="halls-add-dialog-box">
                    <div onclick="closeDialog();">x</div>
                    <span>Edit hall</span>
                    <br />
                    <input type="text" name="uid" placeholder="Uid" value="<?= $hall->uid; ?>"/>
                    <br />
                    <input type="text" name="type" placeholder="Type" value="<?= $hall->type; ?>"/>
                    <br />
                    <input type="number" name="id" value="<?= $hall->id; ?>" style="display: none;" />
                    <br />
                    <input type="submit" value="Edit" />
                </div>
            </form>
        </section>
        <?php
    }

    if ($user->permission == 0 || $user->permission == 10) {
        ?>
        <section class="hall-add-seat" onclick="openDialogProgram();">
            Add seat
        </section>
        <section class="hall-add-seat-dialog-container" id="hall-add-seat-dialog">
            <form action="./actions/addSeat.php" method="post">
                <div class="hall-add-seat-dialog-box">
                    <div onclick="closeDialogProgram();">x</div>
                    <span>Add seat</span>
                    <br />
                    <input type="number" name="posX" placeholder="Pos X">
                    <br />
                    <input type="number" name="posY" placeholder="Pos Y">
                    <br />
                    <input type="text" name="type" placeholder="Type">
                    <br />
                    <input type="number" name="hallId" style="display: none;" value="<?= $hall->id; ?>"/>
                    <br />
                    <input type="submit" value="Add" />
                </div>
            </form>
        </section>
        <script type="text/javascript" src="js/halls.js"></script>
        <?php
    }
}
?>

