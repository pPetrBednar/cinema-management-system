<?php
defined('LOADER') || die("Ah, i see what you did there. No direct access next time!");

include_once 'includes/classes/Database.php';
include_once 'includes/classes/DatabaseManager.php';
include_once 'includes/classes/User.php';
include_once 'includes/classes/Cinema.php';

$dbm = new DatabaseManager;
$id = filter_input(INPUT_GET, 'id');

if ($id) {
    $_SESSION['lastCinema'] = $id;
    try {
        $cinema = $dbm->getCinema($id);
    } catch (NO_DATA_FOUND_EXCEPTION $e) {
        $cinema = null;
    }
}

if ($cinema != null) {
    ?>
    <div class="cinema-container">
        <div class="cinema-box">
            <div>
                <div>
                    <img src="<?= $cinema->coverUrl == null ? "img/placeholder-image.png" : $cinema->coverUrl; ?>" />
                </div>
            </div>
            <div>
                <div><?= $cinema->title; ?></div>
                <div><span>City:</span> <?= $cinema->city; ?></div>
                <div><span>Address:</span> <?= $cinema->address; ?></div>
            </div>
        </div>
        <div class="cinema-program">
            <div>
                Program:
            </div>
            <table>
                <tr>
                    <?php
                    for ($i = 0; $i < 24; $i++) {
                        ?>
                        <th><?= $i . ":00"; ?></th>
                        <?php
                    }
                    ?>
                </tr>
                <tr></tr>
                <tr></tr>
                <tr></tr>
                <tr></tr>
            </table>
        </div>
    </div>
    <?php
}

if (!empty($_SESSION['user'])) {
    $user = unserialize($_SESSION['user']);
    if ($user->permission == 0) {
        ?>
        <div class="cinemas-add" onclick="openDialog();">
            Edit cinema
        </div>
        <div class="cinemas-add-dialog-container" id="cinemas-add-dialog">
            <form action="./actions/editCinema.php" method="post">
                <div class="cinemas-add-dialog-box">
                    <div onclick="closeDialog();">x</div>
                    <span>Edit cinema</span>
                    <br />
                    <input type="text" name="title" placeholder="Title" value="<?= $cinema->title; ?>" />
                    <br />
                    <input type="text" name="city" placeholder="City" value="<?= $cinema->city; ?>" />
                    <br />
                    <input type="text" name="address" placeholder="Address" value="<?= $cinema->address; ?>" />
                    <br />
                    <input type="text" name="coverUrl" placeholder="Cover Url" value="<?= $cinema->coverUrl; ?>"/>
                    <input type="text" name="id" style="display: none;" value="<?= $cinema->id; ?>"/>
                    <br />
                    <input type="submit" value="Edit" />
                </div>
            </form>
        </div>
        <script type="text/javascript" src="js/cinemas.js"></script>
        <?php
    }
}
?>

