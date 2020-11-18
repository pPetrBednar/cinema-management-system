<?php
defined('LOADER') || die("Ah, i see what you did there. No direct access next time!");
?>
<div class="container-login" id="login">
    <form action="<?= $_SERVER['PHP_SELF']; ?>" method="post">
        <div class="box-login">
            <span>Login</span>
            <br />
            <input type="text" name="email" placeholder="Email" />
            <br />
            <input type="password" name="password" placeholder="Password" />

            <div>
                No account?
                <span onclick="window.open('register.php', '_self')">Register</span>
            </div>
            <input type="submit" value="Login" />
        </div>
    </form>
</section>