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

if (!empty($_SESSION['user'])) {
    $user = unserialize($_SESSION['user']);
} else {
    $user = null;
}
?>
<section class="movies-container" id="movies">
    <h2 class="display-none">Movies</h2>
    <?php
    if ($movies != null) {
        foreach ($movies as $movie) {
            ?>
            <div class="movies-gallery-item" onclick="window.open('movie.php?id=<?= $movie->id; ?>', '_self')">
                <?php
                if ($user != null && $user->permission == 0) {
                    ?>
                    <form action="./actions/deleteMovie.php" method="post">
                        <input type="number" name="id" value="<?= $movie->id; ?>" style="display: none;">
                        <button type="submit">x</button>
                    </form>
                    <?php
                }
                ?>
                <img src="<?= $movie->coverUrl == null ? "img/placeholder-image.png" : $movie->coverUrl; ?>" alt="<?= $movie->title . " cover image"; ?>" />
                <div>
                    <span><?= $movie->title; ?></span>
                    <span><?= $movie->year; ?></span>
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
    <section class="movies-add" onclick="openDialog();">
        <h3>Add new movie</h3>
    </section>
    <section class="movies-add-dialog-container" id="movies-add-dialog">
        <form action="./actions/addMovie.php" method="post">
            <div class="movies-add-dialog-box">
                <div onclick="closeDialog();">x</div>
                <h3>Add movie</h3>
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
    </section>
    <script src="js/movies.js"></script>
    <?php
}
?>

