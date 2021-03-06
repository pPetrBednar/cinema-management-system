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
        <h2 class="display-none">Hall</h2>
        <div class="hall-box">
            <div>
                <div>
                    <img src="img/placeholder-image.png" alt="<?= $hall->title . " cover image"; ?>" />
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
        <section class="hall-import" onclick="openDialogImport();">
            <h3>Import seats</h3>
        </section>
        <section class="halls-add-dialog-container" id="hall-import-dialog">
            <form action="./actions/import.php" method="post" enctype="multipart/form-data">
                <div class="halls-add-dialog-box">
                    <div onclick="closeDialogImport();">x</div>
                    <h3>Edit hall</h3>
                    <br />
                    <input type="file" name="file">
                    <br />
                    <input type="submit" value="Import" />
                </div>
            </form>
        </section>
        <section class="hall-export" onclick="exportHall();">
            <h3>Export seats</h3>
        </section>
        <section class="halls-add" onclick="openDialog();">
            <h3>Edit hall</h3>
        </section>
        <section class="halls-add-dialog-container" id="halls-add-dialog">
            <form action="./actions/editHall.php" method="post">
                <div class="halls-add-dialog-box">
                    <div onclick="closeDialog();">x</div>
                    <h3>Edit hall</h3>
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
            <h3>Add seat</h3>
        </section>
        <section class="hall-add-seat-dialog-container" id="hall-add-seat-dialog">
            <form action="./actions/addSeat.php" method="post">
                <div class="hall-add-seat-dialog-box">
                    <div onclick="closeDialogProgram();">x</div>
                    <h3>Add seat</h3>
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
        <script src="js/halls.js"></script>
        <?php
    }
}
?>

