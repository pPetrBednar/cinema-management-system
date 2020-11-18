<?php
defined('LOADER') || die("Ah, i see what you did there. No direct access next time!");

include_once 'includes/classes/Database.php';
include_once 'includes/classes/DatabaseManager.php';
include_once 'includes/classes/User.php';
include_once 'includes/classes/Movie.php';

$dbm = new DatabaseManager;
$id = filter_input(INPUT_GET, 'id');

if ($id) {
    $_SESSION['lastMovie'] = $id;
    try {
        $movie = $dbm->getMovie($id);
    } catch (NO_DATA_FOUND_EXCEPTION $e) {
        $movie = null;
    }
}

if ($movie != null) {
    ?>
    <section class="movie-container" id="movie">
        <div class="movie-box">
            <div>
                <div>
                    <img src="<?= $movie->coverUrl == null ? "img/placeholder-image.png" : $movie->coverUrl; ?>" />
                </div>
            </div>
            <div>
                <div><?= $movie->title; ?></div>
                <div><span>Aired:</span><br><?= $movie->year; ?></div>
                <div><span>Duration:</span><br><?= $movie->duration; ?><span> minutes</span></div>
                <div><span>Description:</span><br><?= $movie->description; ?></div>
            </div>
        </div>
    </section>
    <?php
}

if (!empty($_SESSION['user'])) {
    $user = unserialize($_SESSION['user']);
    if ($user->permission == 0) {
        ?>
        <section class="movies-add" onclick="openDialog();">
            Edit movie
        </section>
        <section class="movies-add-dialog-container" id="movies-add-dialog">
            <form action="./actions/editMovie.php" method="post">
                <div class="movies-add-dialog-box">
                    <div onclick="closeDialog();">x</div>
                    <span>Edit movie</span>
                    <br />
                    <input type="text" name="title" placeholder="Title" value="<?= $movie->title; ?>" />
                    <br />
                    <input type="number" name="year" placeholder="Year" value="<?= $movie->year; ?>" />
                    <br />
                    <input type="number" name="duration" placeholder="Duration" value="<?= $movie->duration; ?>" />
                    <br />
                    <input type="text" name="description" placeholder="Description" value="<?= $movie->description; ?>" />
                    <br />
                    <input type="text" name="coverUrl" placeholder="Cover Url" value="<?= $movie->coverUrl; ?>"/>
                    <input type="text" name="id" style="display: none;" value="<?= $movie->id; ?>"/>
                    <br />
                    <input type="submit" value="Edit" />
                </div>
            </form>
        </section>
        <script type="text/javascript" src="js/movies.js"></script>
        <?php
    }
}
?>

