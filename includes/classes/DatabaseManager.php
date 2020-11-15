<?php

class NO_DATA_FOUND_EXCEPTION extends Exception {

    public function __construct() {
        parent::__construct("User not found");
    }

}

class NO_DATA_ADDED_EXCEPTION extends Exception {

    public function __construct() {
        parent::__construct("User not found");
    }

}

class USER_NOT_FOUND_EXCEPTION extends Exception {

    public function __construct() {
        parent::__construct("User not found");
    }

}

class WRONG_PASSWORD_EXCEPTION extends Exception {

    public function __construct() {
        parent::__construct("Wrong password");
    }

}

class REGISTRATION_FAILED_EXCEPTION extends Exception {

    public function __construct() {
        parent::__construct("Registration failed");
    }

}

class PASSWORDS_MISMATCH_EXCEPTION extends Exception {

    public function __construct() {
        parent::__construct("Passwords mismatch");
    }

}

final class DatabaseManager extends Database {

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

    public function getAllMovies() {

        $stmt = $this->connect()->prepare("SELECT * FROM movies ORDER BY title ASC");
        $stmt->execute();

        if ($stmt->rowCount()) {
            $res = array();
            while ($row = $stmt->fetch()) {
                array_push($res, new Movie($row['id'], $row['title'], $row['year'], $row['duration'], $row['description'], $row['cover_url']));
            }
            return $res;
        }

        throw new NO_DATA_FOUND_EXCEPTION;
    }

    public function addMovie($title, $year, $duration, $description, $coverUrl) {

        $stmt = $this->connect()->prepare("INSERT INTO movies (id, title, year, duration, description, cover_url) VALUES (NULL, ?, ?, ?, ?, ?)");
        $stmt->execute([$title, $year, $duration, $description, $coverUrl]);

        if (!$stmt->rowCount()) {
            throw new NO_DATA_ADDED_EXCEPTION;
        }
    }

    public function editMovie($id, $title, $year, $duration, $description, $coverUrl) {
        $stmt = $this->connect()->prepare("UPDATE movies SET title = ?, year = ?, duration = ?, description = ?, cover_url = ? WHERE id = ?");
        $stmt->execute([$title, $year, $duration, $description, $coverUrl, $id]);
    }

    public function getMovie($id) {

        $stmt = $this->connect()->prepare("SELECT * FROM movies WHERE id = ?");
        $stmt->execute([$id]);

        if ($stmt->rowCount()) {
            while ($row = $stmt->fetch()) {
                return new Movie($row['id'], $row['title'], $row['year'], $row['duration'], $row['description'], $row['cover_url']);
            }
        }

        throw new NO_DATA_FOUND_EXCEPTION;
    }

    public function getAllCinemas() {

        $stmt = $this->connect()->prepare("SELECT * FROM cinemas ORDER BY title ASC");
        $stmt->execute();

        if ($stmt->rowCount()) {
            $res = array();
            while ($row = $stmt->fetch()) {
                array_push($res, new Cinema($row['id'], $row['title'], $row['city'], $row['address'], $row['cover_url']));
            }
            return $res;
        }

        throw new NO_DATA_FOUND_EXCEPTION;
    }

    public function addCinema($title, $city, $address, $coverUrl) {

        $stmt = $this->connect()->prepare("INSERT INTO cinemas (id, title, city, address, cover_url) VALUES (NULL, ?, ?, ?, ?)");
        $stmt->execute([$title, $city, $address, $coverUrl]);

        if (!$stmt->rowCount()) {
            throw new NO_DATA_ADDED_EXCEPTION;
        }
    }

    public function editCinema($id, $title, $city, $address, $coverUrl) {
        $stmt = $this->connect()->prepare("UPDATE cinemas SET title = ?, city = ?, address = ?, cover_url = ? WHERE id = ?");
        $stmt->execute([$title, $city, $address, $coverUrl, $id]);
    }

    public function getCinema($id) {

        $stmt = $this->connect()->prepare("SELECT * FROM cinemas WHERE id = ?");
        $stmt->execute([$id]);

        if ($stmt->rowCount()) {
            while ($row = $stmt->fetch()) {
                return new Cinema($row['id'], $row['title'], $row['city'], $row['address'], $row['cover_url']);
            }
        }

        throw new NO_DATA_FOUND_EXCEPTION;
    }

}
