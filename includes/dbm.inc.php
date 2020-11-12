<?php

class NO_DATA_FOUND_EXCEPTION extends Exception {
    public function __construct() {
        $this->message = "User not found";
    }
}

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

class PASSWORDS_MISMATCH_EXCEPTION extends Exception {
    public function __construct() {
        $this->message = "Passwords mismatch";
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
                $_SESSION["user"] = serialize(new User($rec["email"], $rec["first_name"], $rec["last_name"], $rec["permission"], $rec["registered"]));
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

    public function register($email, $password, $passwordAgain) {

        if ($password != $passwordAgain) {
            throw new PASSWORDS_MISMATCH_EXCEPTION;
        }

        $stmt = $this->connect()->prepare("INSERT INTO users (id, email, password) VALUES (NULL, ?, ?)");
        $stmt->execute([$email, password_hash($password, PASSWORD_BCRYPT, $this->bCryptOptions)]);

        if (!$stmt->rowCount()) {
            throw new REGISTRATION_FAILED_EXCEPTION;
        }
    }

    public function getAllUsers() {

        $stmt = $this->connect()->prepare("SELECT email, first_name, last_name, permission, registered FROM users ORDER BY registered ASC");
        $stmt->execute();

        if ($stmt->rowCount()) {
            $res = array();
            while ($row = $stmt->fetch()) {
                array_push($res, new User($row['email'], $row['first_name'], $row['last_name'], $row['permission'], $row['registered']));
            }
            return $res;
        }

        throw new NO_DATA_FOUND_EXCEPTION;
    }

    public function editUserAdmin($email, $firstName, $lastName, $permission) {
        $stmt = $this->connect()->prepare("UPDATE users SET email = ?, first_name = ?, last_name = ?, permission = ? WHERE email = ?");
        $stmt->execute([$email, $firstName, $lastName, $permission, $email]);
    }

    public function editUser($email, $firstName, $lastName) {
        $stmt = $this->connect()->prepare("UPDATE users SET first_name = ?, last_name = ? WHERE email = ?");
        $stmt->execute([$firstName, $lastName, $email]);
    }

    public function deleteUser($email) {
        $stmt = $this->connect()->prepare("DELETE FROM users WHERE email=?");
        $stmt->execute([$email]);
    }
}
