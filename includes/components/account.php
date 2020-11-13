<?php
defined('LOADER') || die("Ah, i see what you did there. No direct access next time!");
$user = unserialize($_SESSION['user']);
?>
<div class="account-container">
    <div class="account-box">
        <form action="edit.admin.php" method="post">
            <input type="text" name="action" value="editUser" style="display: none;">
            <div class="account-item">
                <div>Email address:</div>
                <div><?= $user->email; ?></div>
            </div>
            <div class="account-item">
                <div>First name:</div>
                <div>
                    <div id="firstName"><?= $user->firstName == "" ? "?" : $user->firstName; ?></div>
                    <input id="firstNameInput" type="text" name="firstName" value="<?= $user->firstName; ?>" style="display: none;">
                </div>
            </div>
            <div class="account-item">
                <div>Last name:</div>
                <div>
                    <div id="lastName"><?= $user->lastName == "" ? "?" : $user->lastName; ?></div>
                    <input id="lastNameInput" type="text" name="lastName" value="<?= $user->lastName; ?>" style="display: none;">
                </div>
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
                    <div id="editInformationBtn" onclick="editInformation()">Edit information</div>
                    <button type="submit" id="editInformationBtnSubmit" style="display: none;">Save information</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript" src="js/account.js"></script>