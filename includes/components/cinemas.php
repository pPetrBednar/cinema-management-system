<?php
defined('LOADER') || die("Ah, i see what you did there. No direct access next time!");

include_once 'includes/classes/Database.php';
include_once 'includes/classes/DatabaseManager.php';
include_once 'includes/classes/User.php';
include_once 'includes/classes/Cinema.php';

$dbm = new DatabaseManager;

try {
    $cinemas = $dbm->getAllCinemas();
} catch (NO_DATA_FOUND_EXCEPTION $e) {
    $cinemas = null;
}

if (!empty($_SESSION['user'])) {
    $user = unserialize($_SESSION['user']);
} else {
    $user = null;
}
?>
<section class="cinemas-container" id="cinemas">
    <h2 class="display-none">Cinemas</h2>
    <?php
    if ($cinemas != null) {
        foreach ($cinemas as $cinema) {
            ?>
            <div class="gallery-item" onclick="window.open('cinema.php?id=<?= $cinema->id; ?>', '_self')">
                <?php
                if ($user != null && $user->permission == 0) {
                    ?>
                    <form action="./actions/deleteCinema.php" method="post">
                        <input type="number" name="id" value="<?= $cinema->id; ?>" style="display: none;">
                        <button type="submit">x</button>
                    </form>
                    <?php
                }
                ?>
                <img class="gallery-img" src="<?= $cinema->coverUrl == null ? "img/placeholder-image.png" : $cinema->coverUrl; ?>" alt="<?= $cinema->title . " cover image"; ?>" />
                <div>
                    <span><?= $cinema->title; ?></span>
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
    <section class="cinemas-add" onclick="openDialog();">
        <h3>Add new cinema</h3>
    </section>
    <section class="cinemas-add-dialog-container" id="cinemas-add-dialog">
        <form action="./actions/addCinema.php" method="post">
            <div class="cinemas-add-dialog-box">
                <div onclick="closeDialog();">x</div>
                <h3>Add cinema</h3>
                <br />
                <input type="text" name="title" placeholder="Title" />
                <br />
                <input type="text" name="city" placeholder="City" />
                <br />
                <input type="text" name="address" placeholder="Address" />
                <br />
                <input type="text" name="coverUrl" placeholder="Cover Url" />
                <br />
                <input type="submit" value="Add" />
            </div>
        </form>
    </section>
    <script src="js/cinemas.js"></script>
    <?php
}
?>

