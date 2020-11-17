<?php

session_start();

if (empty($_SESSION['user'])) {
    die("Ah, i see what you did there. No direct access next time!");
}

if (isset($_SESSION['reservations'])) {
    unset($_SESSION['reservations']);
}

header("Location: ../");
