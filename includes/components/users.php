<?php
defined('LOADER') || die("Ah, i see what you did there. No direct access next time!");

include_once 'includes/classes/Database.php';
include_once 'includes/classes/DatabaseManager.php';
include_once 'includes/classes/User.php';

$dbm = new DatabaseManager;

if (!empty($_SESSION['user'])) {
    $user = unserialize($_SESSION['user']);

    if ($user->permission == 0) {
        ?>
        <div class="users-container">
            <table>
                <tr>
                    <th>Email</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Permission</th>
                    <th>Registered</th>
                    <th>Action edit</th>
                    <th>Action delete</th>
                </tr>
                <?php
                $dbm = new DatabaseManager;

                try {
                    $users = $dbm->getAllUsers();
                } catch (NO_DATA_FOUND_EXCEPTION $e) {
                    $users = null;
                }

                if ($users != null) {
                    foreach ($users as $res) {
                        if ($user->email == $res->email) {
                            continue;
                        }
                        $date = DateTime::createFromFormat("Y-m-d H:i:s", $res->registered);
                        ?>
                        <tr>
                        <form action="./actions/editUser.php" method="post">
                            <td>
                                <input type="text" name="email" value="<?= $res->email; ?>">
                            </td>
                            <td>
                                <input type="text" name="firstName" value="<?= $res->firstName; ?>">
                            </td>
                            <td>
                                <input type="text" name="lastName" value="<?= $res->lastName; ?>">
                            </td>
                            <td>
                                <input type="text" name="permission" value="<?= $res->permission; ?>">
                            </td>
                            <td><?= $date->format("H:i d. m. Y"); ?></td>
                            <td>
                                <input type="number" name="id" value="<?= $res->id; ?>" style="display: none;">
                                <button type="submit">Edit</button>
                            </td>
                        </form>
                        <td>
                            <form action="./actions/deleteUser.php" method="post">
                                <input type="number" name="id" value="<?= $res->id; ?>" style="display: none;">
                                <button type="submit">Delete</button>
                            </form>
                        </td>
                        </tr>
                        <?php
                    }
                }
                ?>
            </table>
        </div>
        <?php
    }
}
?>
