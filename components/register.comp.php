<?php
defined('LOADER') || die("Ah, i see what you did there. No direct access next time!");
?>
<div class="container-register">
    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
        <div class="box-register">
            <span>Register</span>
            <br />
            <input type="text" name="email" placeholder="Email" />
            <br />
            <input type="password" name="password" placeholder="Password" />
            <br />
            <input type="password" name="passwordAgain" placeholder="Password again" />

            <div>
                Already have an account?
                <span onclick="window.open('login.php', '_self')">Login</span>
            </div>
            <input type="submit" value="Register" />
        </div>
    </form>
</div>