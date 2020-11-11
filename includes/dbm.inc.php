<?php

class USER_NOT_FOUND_EXCEPTION extends Exception {
    public function __construct() {
        $this->message = "User not found";
    }
}

class WRONG_PASSWORD_EXCEPTION extends Exception {
    public function __construct() {
        $this->message = "Wrong password";
    }
}

class REGISTRATION_FAILED_EXCEPTION extends Exception {
    public function __construct() {
        $this->message = "Registration failed";
    }
}

final class Dbm extends Db {

    private $bCryptOptions = [
        'cost' => 10
    ];

    public function login($email, $password) {

        $stmt = $this->connect()->prepare("SELECT * FROM users WHERE email=?");
        $stmt->execute([$email]);

        if ($stmt->rowCount()) {
            $rec = $stmt->fetch();
            if (password_verify($password, $rec["password"])) {
                $_SESSION["user"] = serialize(new User($rec["email"], $rec["first_name"], $rec["last_name"], $rec["registered"]));
            } else {
                throw new WRONG_PASSWORD_EXCEPTION;
            }
        } else {
            throw new USER_NOT_FOUND_EXCEPTION;
        }
    }

    public function logout() {
        session_unset();
        session_destroy();
    }

    public function register($email, $password) {
        $stmt = $this->connect()->prepare("INSERT INTO users (id, email, password) VALUES (NULL, ?, ?)");
        $stmt->execute([$email, password_hash($password, PASSWORD_BCRYPT, $this->bCryptOptions)]);

        if (!$stmt->rowCount()) {
            throw new REGISTRATION_FAILED_EXCEPTION;
        }
    }
}
