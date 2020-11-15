<?php
defined('LOADER') || die("Ah, i see what you did there. No direct access next time!");

include_once 'includes/classes/Database.php';
include_once 'includes/classes/DatabaseManager.php';
include_once 'includes/classes/User.php';
include_once 'includes/classes/Movie.php';

$dbm = new DatabaseManager;

try {
    $movies = $dbm->getAllMovies();
} catch (NO_DATA_FOUND_EXCEPTION $e) {
    $movies = null;
}
?>
<div class="movies-container" id="movies">
    <?php
    if ($movies != null) {
        foreach ($movies as $movie) {
            ?>
            <div class="movies-gallery-item" onclick="window.open('movie.php?id=<?= $movie->id; ?>', '_self')">
                <img src="<?= $movie->coverUrl == null ? "img/placeholder-image.png" : $movie->coverUrl; ?>" />
                <div>
                    <span><?= $movie->title; ?></span>
                    <span><?= $movie->year; ?></span>
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
        <div class="movies-add" onclick="openDialog();">
            Add new movie
        </div>
        <div class="movies-add-dialog-container" id="movies-add-dialog">
            <form action="./actions/addMovie.php" method="post">
                <div class="movies-add-dialog-box">
                    <div onclick="closeDialog();">x</div>
                    <span>Add movie</span>
                    <br />
                    <input type="text" name="title" placeholder="Title" />
                    <br />
                    <input type="number" name="year" placeholder="Year" />
                    <br />
                    <input type="number" name="duration" placeholder="Duration" />
                    <br />
                    <input type="text" name="description" placeholder="Description" />
                    <br />
                    <input type="text" name="coverUrl" placeholder="Cover Url" />
                    <br />
                    <input type="submit" value="Add" />
                </div>
            </form>
        </div>
        <script type="text/javascript" src="js/movies.js"></script>
        <?php
    }
}
?>

