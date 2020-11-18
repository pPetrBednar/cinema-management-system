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
        <h2 class="display-none">Movie</h2>
        <div class="movie-box">
            <div>
                <div>
                    <img src="<?= $movie->coverUrl == null ? "img/placeholder-image.png" : $movie->coverUrl; ?>" alt="<?= $movie->title . " cover image"; ?>" />
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
            <h3>Edit movie</h3>
        </section>
        <section class="movies-add-dialog-container" id="movies-add-dialog">
            <form action="./actions/editMovie.php" method="post">
                <div class="movies-add-dialog-box">
                    <div onclick="closeDialog();">x</div>
                    <h3>Edit movie</h3>
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
        <script src="js/movies.js"></script>
        <?php
    }
}
?>

