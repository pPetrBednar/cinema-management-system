<?php
defined('LOADER') || die("Ah, i see what you did there. No direct access next time!");
?>
<section id="menu">
    <header class="menu-title" onclick="window.open('./', '_self')">Cinematic</header>
    <div class="menu-header">
        Portal
    </div>
    <div class="menu-item" onclick="window.open('movies.php', '_self')">
        Movies
    </div>
    <div class="menu-item" onclick="window.open('cinemas.php', '_self')">
        Cinemas
    </div>
    <?php
    if (!empty($_SESSION['user'])) {
        $user = unserialize($_SESSION['user']);
        if ($user->permission == 0) {
            ?>
            <div class="menu-header">
                Administration
            </div>
            <div class="menu-item" onclick="window.open('users.php', '_self')">
                Users
            </div>
            <div class="menu-item" onclick="window.open('movies.php', '_self')">
                Movies
            </div>
            <div class="menu-item" onclick="window.open('cinemas.php', '_self')">
                Cinemas
            </div>
            <div class="menu-item" onclick="window.open('reservations.php', '_self')">
                Reservations
            </div>
            <div class="menu-item" onclick="window.open('completedOrder.php', '_self')">
                Completed orders
            </div>
            <?php
        }

        if ($user->permission == 10) {
            ?>
            <div class="menu-header">
                Administration
            </div>
            <div class="menu-item" onclick="window.open('reservations.php', '_self')">
                Reservations
            </div>
            <div class="menu-item" onclick="window.open('completedOrder.php', '_self')">
                Completed orders
            </div>
            <?php
        }
    }
    ?>
    <div class="menu-header">
        User
    </div>
    <?php
    if (empty($_SESSION['user'])) {
        ?>
        <div class="menu-item" onclick="window.open('login.php', '_self')">
            Login
        </div>
        <div class="menu-item" onclick="window.open('register.php', '_self')">
            Register
        </div>
        <?php
    } else {
        ?>
        <div class="menu-item" onclick="window.open('orders.php', '_self')">
            Orders
        </div>
        <div class="menu-item" onclick="window.open('history.php', '_self')">
            History
        </div>
        <div class="menu-item-account">
            <div class="menu-item" onclick="window.open('account.php', '_self')">
                Account
            </div>
            <div class="menu-item-logout" onclick="window.open('./actions/logout.php', '_self')">
                &larr;
            </div>
        </div>
        <?php
    }
    ?>
</section>