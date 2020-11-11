<?php
defined('LOADER') || die("Ah, i see what you did there. No direct access next time!");
$user = unserialize($_SESSION['user']);
?>
<div class="account-container">
    <div class="account-box">
        <div class="account-item">
            <div>Email address:</div>
            <div><?= $user->email; ?></div>
        </div>
        <div class="account-item">
            <div>First name:</div>
            <div><?= $user->firstname == "" ? "?" : $user->firstname; ?></div>
        </div>
        <div class="account-item">
            <div>Last name:</div>
            <div><?= $user->lastname == "" ? "?" : $user->lastname; ?></div>
        </div>
        <div class="account-item">
            <div>Permission level:</div>
            <div><?= $user->permission == "0" ? "Administrator" : "User"; ?></div>
        </div>
        <div class="account-item">
            <div>Account created:</div>
            <div><?= $user->registered; ?></div>
        </div>
        <div class="account-edit">
            <div>
                <div>Change password</div>
            </div>
            <div>
                <div>Edit information</div>
            </div>
        </div>
    </div>
</div>