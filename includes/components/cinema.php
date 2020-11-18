<?php
defined('LOADER') || die("Ah, i see what you did there. No direct access next time!");

include_once 'includes/classes/Database.php';
include_once 'includes/classes/DatabaseManager.php';
include_once 'includes/classes/User.php';
include_once 'includes/classes/Cinema.php';
include_once 'includes/classes/Movie.php';
include_once 'includes/classes/Hall.php';
include_once 'includes/classes/ProgramEntry.php';

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

if (!empty($_SESSION['user'])) {
    $user = unserialize($_SESSION['user']);
} else {
    $user = null;
}

if ($cinema != null) {
    ?>
    <section class="cinema-container" id="cinema">
        <h2 class="display-none">Cinema</h2>
        <div class="cinema-box">
            <div>
                <div>
                    <img src="<?= $cinema->coverUrl == null ? "img/placeholder-image.png" : $cinema->coverUrl; ?>" alt="<?= $cinema->title . " cover image"; ?>"/>
                </div>
            </div>
            <div>
                <div><?= $cinema->title; ?></div>
                <div><span>City:</span><br><?= $cinema->city; ?></div>
                <div><span>Address:</span><br><?= $cinema->address; ?></div>
                <div onclick="window.open('halls.php?cinema=<?= $cinema->id; ?>', '_self')">
                    Cinema halls
                </div>
            </div>
        </div>
        <div class="cinema-program">
            <div>
                Program:
            </div>
            <table>
                <tr>
                    <th>
                        Date
                    </th>
                    <th>
                        Movie
                    </th>
                    <?php
                    for ($i = 0; $i < 24; $i++) {
                        ?>
                        <th></th>
                        <?php
                    }
                    if ($user != null && ($user->permission == 0 || $user->permission == 10)) {
                        ?>
                        <th></th>
                        <?php
                    }
                    ?>
                </tr>
                <?php
                try {
                    $programEntries = $dbm->getProgramEntriesOfCinema($id);
                } catch (NO_DATA_FOUND_EXCEPTION $e) {
                    $programEntries = null;
                }

                if ($programEntries != null) {
                    foreach ($programEntries as $programEntry) {
                        $date = DateTime::createFromFormat("Y-m-d H:i:s", $programEntry->start);
                        ?>
                        <tr onclick="window.open('reservation.php?programEntry=<?= $programEntry->id; ?>', '_self')">
                            <td><?= $date->format("d. m. Y"); ?></td>
                            <td><?= $programEntry->movie->title; ?></td>
                            <?php
                            for ($i = 0; $i < 24; $i++) {
                                if ($date->format('H') == $i) {
                                    ?>
                                    <td><?= $date->format('H:i'); ?></td>
                                    <?php
                                } else {
                                    ?>
                                    <td></td>
                                    <?php
                                }
                            }
                            if ($user != null && ($user->permission == 0 || $user->permission == 10)) {
                                ?>
                                <td class="cinema-program-delete">
                                    <form action="./actions/deleteProgramEntry.php" method="post">
                                        <input type="number" name="id" value="<?= $programEntry->id; ?>" style="display: none;">
                                        <button type="submit">x</button>
                                    </form>
                                </td>
                                <?php
                            }
                            ?>     
                        </tr>    
                        <?php
                    }
                }
                ?>
            </table>
        </div>
    </section>
    <?php
}

if ($user != null && $user->permission == 0) {
    ?>
    <section class="cinemas-add" onclick="openDialog();">
        <h3>Edit cinema</h3>
    </section>
    <section class="cinemas-add-dialog-container" id="cinemas-add-dialog">
        <form action="./actions/editCinema.php" method="post">
            <div class="cinemas-add-dialog-box">
                <div onclick="closeDialog();">x</div>
                <h3>Edit cinema</h3>
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
    </section>
    <?php
}

if ($user != null && ($user->permission == 0 || $user->permission == 10)) {
    ?>
    <section class="cinema-add-program" onclick="openDialogProgram();">
        <h3>Add program entry</h3>
    </section>
    <section class="cinema-add-program-dialog-container" id="cinema-add-program-dialog">
        <form action="./actions/addProgramEntry.php" method="post">
            <div class="cinema-add-program-dialog-box">
                <div onclick="closeDialogProgram();">x</div>
                <h3>Add program entry</h3>
                <br />
                <input type="datetime-local" name="start">
                <br />
                <input type="number" name="price" placeholder="Price">
                <br />
                <select name="movies">
                    <?php
                    try {
                        $movies = $dbm->getAllMovies();
                    } catch (NO_DATA_FOUND_EXCEPTION $e) {
                        $movies = null;
                    }

                    if ($movies != null) {
                        foreach ($movies as $movie) {
                            ?>
                            <option value="<?= $movie->id; ?>"><?= $movie->title . " (" . $movie->year . ")" ?></option>
                            <?php
                        }
                    }
                    ?>
                </select>
                <br />
                <select name="halls">
                    <?php
                    try {
                        $halls = $dbm->getHallsOfCinema($cinema->id);
                    } catch (NO_DATA_FOUND_EXCEPTION $e) {
                        $halls = null;
                    }

                    if ($halls != null) {
                        foreach ($halls as $hall) {
                            ?>
                            <option value="<?= $hall->id; ?>"><?= $hall->uid . " (" . $hall->type . ")" ?></option>
                            <?php
                        }
                    }
                    ?>
                </select>
                <input type="text" name="id" style="display: none;" value="<?= $cinema->id; ?>"/>
                <br />
                <input type="submit" value="Add" />
            </div>
        </form>
    </section>
    <script src="js/cinemas.js"></script>
    <?php
}
?>

