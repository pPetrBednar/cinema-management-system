<?php
defined('LOADER') || die("Ah, i see what you did there. No direct access next time!");
$user = unserialize($_SESSION['user']);
?>
<section class="account-container" id="account">
    <div class="account-box">
        <form action="./actions/editAccount.php" method="post">
            <input type="text" name="action" value="editUser" style="display: none;">
            <div class="account-item">
                <div>Email address:</div>
                <div><?= $user->email; ?></div>
            </div>
            <div class="account-item">
                <div>First name:</div>
                <div>
                    <div id="firstName"><?= $user->firstName == "" ? "?" : $user->firstName; ?></div>
                    <input id="firstNameInput" type="text" name="firstName" value="<?= $user->firstName; ?>" placeholder="First name" style="display: none;">
                </div>
            </div>
            <div class="account-item">
                <div>Last name:</div>
                <div>
                    <div id="lastName"><?= $user->lastName == "" ? "?" : $user->lastName; ?></div>
                    <input id="lastNameInput" type="text" name="lastName" value="<?= $user->lastName; ?>" placeholder="Last name" style="display: none;">
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
                    <div onclick="openDialog();">Change password</div>
                </div>
                <div>
                    <div id="editInformationBtn" onclick="editInformation()">Edit information</div>
                    <button type="submit" id="editInformationBtnSubmit" style="display: none;">Save information</button>
                </div>
            </div>
        </form>
    </div>
</section>
<section class="account-change-password-dialog-container" id="account-change-password-dialog">
    <form action="./actions/changePassword.php" method="post">
        <div class="account-change-password-dialog-box">
            <div onclick="closeDialog();">x</div>
            <span>Change password</span>
            <br />
            <input type="password" name="password" placeholder="Password">
            <br />
            <input type="password" name="passwordAgain" placeholder="Password again">
            <br />
            <input type="submit" value="Change" />
        </div>
    </form>
</section>
<script type="text/javascript" src="js/account.js"></script>