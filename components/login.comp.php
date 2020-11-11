<div class="container-login">
    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
        <div class="login">
            <span>Login</span>
            <br />
            <input type="text" name="email" placeholder="Email" />
            <br />
            <input type="password" name="password" placeholder="Password" />

            <div>
                No account?
                <span onclick="window.open('register.php', '_self')">Register</span>
            </div>
            <input type="submit" value="Enter" />
        </div>
    </form>
</div>