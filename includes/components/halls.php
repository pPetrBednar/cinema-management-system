<?php
defined('LOADER') || die("Ah, i see what you did there. No direct access next time!");

include_once 'includes/classes/Database.php';
include_once 'includes/classes/DatabaseManager.php';
include_once 'includes/classes/User.php';
include_once 'includes/classes/Hall.php';

$dbm = new DatabaseManager;
$id = filter_input(INPUT_GET, 'cinema');

if ($id) {
    $_SESSION['lastCinema'] = $id;
    try {
        $halls = $dbm->getHallsOfCinema($id);
    } catch (NO_DATA_FOUND_EXCEPTION $e) {
        $halls = null;
    }
} else {
    header("Location: ./");
}

if (!empty($_SESSION['user'])) {
    $user = unserialize($_SESSION['user']);
} else {
    $user = null;
}
?>
<section class="halls-container" id="halls">
    <h2 class="display-none">Halls</h2>
    <?php
    if ($halls != null) {
        foreach ($halls as $hall) {
            ?>
            <div class="gallery-item" onclick="window.open('hall.php?id=<?= $hall->id; ?>', '_self')">
                <?php
                if ($user != null && $user->permission == 0) {
                    ?>
                    <form action="./actions/deleteHall.php" method="post">
                        <input type="number" name="id" value="<?= $hall->id; ?>" style="display: none;">
                        <button type="submit">x</button>
                    </form>
                    <?php
                }
                ?>
                <img class="gallery-img" src="img/placeholder-image.png" alt="<?= $hall->title . " cover image"; ?>" />
                <div>
                    <span><?= $hall->uid; ?></span>
                </div>
            </div>
            <?php
        }
    }
    ?>
</section>
<?php
if ($user != null && $user->permission == 0) {
    ?>
    <section class="halls-add" onclick="openDialog();">
        <h3>Add new hall</h3>
    </section>
    <section class="halls-add-dialog-container" id="halls-add-dialog">
        <form action="./actions/addHall.php" method="post">
            <div class="halls-add-dialog-box">
                <div onclick="closeDialog();">x</div>
                <h3>Add hall</h3>
                <br />
                <input type="text" name="uid" placeholder="Uid" />
                <br />
                <input type="text" name="type" placeholder="Type" />
                <br />
                <input type="number" name="cinemaId" value="<?= $id; ?>" style="display: none;" />
                <br />
                <input type="submit" value="Add" />
            </div>
        </form>
    </section>
    <script src="js/halls.js"></script>
    <?php
}
?>

