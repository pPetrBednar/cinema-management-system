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
?>
<div class="halls-container" id="halls">
    <?php
    if ($halls != null) {
        foreach ($halls as $hall) {
            ?>
            <div class="gallery-item" onclick="window.open('hall.php?id=<?= $hall->id; ?>', '_self')">
                <img class="gallery-img" src="img/placeholder-image.png" />
                <div>
                    <span><?= $hall->uid; ?></span>
                </div>
            </div>
            <?php
        }
    }
    ?>
</div>
<?php
if (!empty($_SESSION['user'])) {
    $user = unserialize($_SESSION['user']);
    if ($user->permission == 0) {
        ?>
        <div class="halls-add" onclick="openDialog();">
            Add new hall
        </div>
        <div class="halls-add-dialog-container" id="halls-add-dialog">
            <form action="./actions/addHall.php" method="post">
                <div class="halls-add-dialog-box">
                    <div onclick="closeDialog();">x</div>
                    <span>Add hall</span>
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
        </div>
        <script type="text/javascript" src="js/halls.js"></script>
        <?php
    }
}
?>

