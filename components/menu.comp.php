<div class="menu">
    <div class="menu-title" onclick="window.open('index.php', '_self')">ProtoT</div>
    <div class="menu-item" onclick="window.open('index.php', '_self')">
        Gallery
    </div>
    <div class="menu-item">-</div>
    <div class="menu-item">-</div>
    <div class="menu-item">-</div>
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
                x
            </div>
        </div>
    <?php
    }
    ?>
</div>