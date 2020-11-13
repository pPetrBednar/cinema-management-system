<?php
defined('LOADER') || die("Ah, i see what you did there. No direct access next time!");
?>
<div class="menu">
    <div class="menu-title" onclick="window.open('index.php', '_self')">Cinematic</div>
    <div class="menu-item" onclick="window.open('index.php', '_self')">
        Gallery
    </div>
    <div class="menu-item">-</div>
    <div class="menu-item">-</div>
    <div class="menu-item">-</div>
    <?php
    if (!empty($_SESSION['user'])) {
        $user = unserialize($_SESSION['user']);
        if ($user->permission == 0) {
    ?>
            <div class="menu-item" onclick="window.open('users.admin.php', '_self')">
                Users
            </div>
    <?php
        }
    }
    ?>
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
        <div class="menu-item-account">
            <div class="menu-item" onclick="window.open('account.php', '_self')">
                Account
            </div>
            <div class="menu-item-logout" onclick="window.open('logout.php', '_self')">
                &larr;
            </div>
        </div>
    <?php
    }
    ?>
</div>