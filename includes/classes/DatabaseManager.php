<?php

class NO_DATA_FOUND_EXCEPTION extends Exception {

    public function __construct() {
        parent::__construct("No data found");
    }

}

class NO_DATA_ADDED_EXCEPTION extends Exception {

    public function __construct() {
        parent::__construct("No data added");
    }

}

class NO_DATA_DELETED_EXCEPTION extends Exception {

    public function __construct() {
        parent::__construct("No data deleted");
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

class RESERVATION_FAILED_EXCEPTION extends Exception {

    public function __construct() {
        parent::__construct("Reservation failed");
    }

}

class ORDER_CONFIRMATION_FAILED_EXCEPTION extends Exception {

    public function __construct() {
        parent::__construct("Confirmation process of order failed");
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
                $_SESSION["user"] = serialize(new User($rec['id'], $rec["email"], $rec["first_name"], $rec["last_name"], $rec["permission"], $rec["registered"]));
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

    public function changePassword($user, $password, $passwordAgain) {

        if ($password != $passwordAgain) {
            throw new PASSWORDS_MISMATCH_EXCEPTION;
        }

        $stmt = $this->connect()->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->execute([password_hash($password, PASSWORD_BCRYPT, $this->bCryptOptions), $user->id]);
    }

    public function getAllUsers() {

        $stmt = $this->connect()->prepare("SELECT id, email, first_name, last_name, permission, registered FROM users ORDER BY registered ASC");
        $stmt->execute();

        if ($stmt->rowCount()) {
            $res = array();
            while ($row = $stmt->fetch()) {
                array_push($res, new User($row['id'], $row['email'], $row['first_name'], $row['last_name'], $row['permission'], $row['registered']));
            }
            return $res;
        }

        throw new NO_DATA_FOUND_EXCEPTION;
    }

    public function editUser($id, $firstName, $lastName, $permission) {
        $stmt = $this->connect()->prepare("UPDATE users SET first_name = ?, last_name = ?, permission = ? WHERE id = ?");
        $stmt->execute([$firstName, $lastName, $permission, $id]);
    }

    public function editAccount($id, $firstName, $lastName) {
        $stmt = $this->connect()->prepare("UPDATE users SET first_name = ?, last_name = ? WHERE id = ?");
        $stmt->execute([$firstName, $lastName, $id]);
    }

    public function deleteUser($id) {
        $stmt = $this->connect()->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$id]);

        if (!$stmt->rowCount()) {
            throw new NO_DATA_DELETED_EXCEPTION;
        }
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

    public function getHallsOfCinema($id) {

        $stmt = $this->connect()->prepare("SELECT * FROM halls WHERE cinema_id = ? ORDER BY uid ASC");
        $stmt->execute([$id]);

        if ($stmt->rowCount()) {
            $res = array();
            while ($row = $stmt->fetch()) {
                array_push($res, new Hall($row['id'], $row['uid'], $row['type'], $row['cinema_id']));
            }
            return $res;
        }

        throw new NO_DATA_FOUND_EXCEPTION;
    }

    public function addHall($uid, $type, $cinemaId) {
        $stmt = $this->connect()->prepare("INSERT INTO halls (id, uid, type, cinema_id) VALUES (NULL, ?, ?, ?)");
        $stmt->execute([$uid, $type, $cinemaId]);

        if (!$stmt->rowCount()) {
            throw new NO_DATA_ADDED_EXCEPTION;
        }
    }

    public function getHall($id) {

        $stmt = $this->connect()->prepare("SELECT * FROM halls WHERE id = ?");
        $stmt->execute([$id]);

        if ($stmt->rowCount()) {
            while ($row = $stmt->fetch()) {
                return new Hall($row['id'], $row['uid'], $row['type'], $row['cinema_id']);
            }
        }

        throw new NO_DATA_FOUND_EXCEPTION;
    }

    public function editHall($id, $uid, $type) {
        $stmt = $this->connect()->prepare("UPDATE halls SET uid = ?, type = ? WHERE id = ?");
        $stmt->execute([$uid, $type, $id]);
    }

    public function addProgramEntry($start, $price, $movieId, $hallId) {
        $stmt = $this->connect()->prepare("INSERT INTO program_entries (id, start, price, movie_id, hall_id) VALUES (NULL, ?, ?, ?, ?)");
        $stmt->execute([$start, $price, $movieId, $hallId]);

        if (!$stmt->rowCount()) {
            throw new NO_DATA_ADDED_EXCEPTION;
        }
    }

    public function getProgramEntriesOfCinema($id) {

        $stmt = $this->connect()->prepare("SELECT `program_entries`.`id`, `start`, `price`, `movie_id`, `hall_id`, `uid`, `type`, `title`, `year`, `duration`  FROM `program_entries` INNER JOIN `movies` ON `movie_id` = `movies`.`id` INNER JOIN `halls` ON `hall_id` = `halls`.`id` WHERE `halls`.`cinema_id` = ? AND `start` > CURRENT_TIMESTAMP ORDER BY `start` ASC");
        $stmt->execute([$id]);

        if ($stmt->rowCount()) {
            $res = array();
            while ($row = $stmt->fetch()) {
                array_push($res, new ProgramEntry($row['id'], $row['start'], $row['price'], new Movie($row['movie_id'], $row['title'], $row['year'], $row['duration'], "", ""), new Hall($row['hall_id'], $row['uid'], $row['type'], $id)));
            }
            return $res;
        }

        throw new NO_DATA_FOUND_EXCEPTION;
    }

    public function addSeat($posX, $posY, $type, $hallId) {
        $stmt = $this->connect()->prepare("INSERT INTO seats (id, pos_x, pos_y, type, hall_id) VALUES (NULL, ?, ?, ?, ?)");
        $stmt->execute([$posX, $posY, $type, $hallId]);

        if (!$stmt->rowCount()) {
            throw new NO_DATA_ADDED_EXCEPTION;
        }
    }

    public function deleteSeat($id) {
        $stmt = $this->connect()->prepare("DELETE FROM seats WHERE id = ?");
        $stmt->execute([$id]);

        if (!$stmt->rowCount()) {
            throw new NO_DATA_DELETED_EXCEPTION;
        }
    }

    public function deleteCinema($id) {
        $stmt = $this->connect()->prepare("DELETE FROM cinemas WHERE id = ?");
        $stmt->execute([$id]);

        if (!$stmt->rowCount()) {
            throw new NO_DATA_DELETED_EXCEPTION;
        }
    }

    public function deleteMovie($id) {
        $stmt = $this->connect()->prepare("DELETE FROM movies WHERE id = ?");
        $stmt->execute([$id]);

        if (!$stmt->rowCount()) {
            throw new NO_DATA_DELETED_EXCEPTION;
        }
    }

    public function deleteHall($id) {
        $stmt = $this->connect()->prepare("DELETE FROM halls WHERE id = ?");
        $stmt->execute([$id]);

        if (!$stmt->rowCount()) {
            throw new NO_DATA_DELETED_EXCEPTION;
        }
    }

    public function deleteProgramEntry($id) {
        $stmt = $this->connect()->prepare("DELETE FROM program_entries WHERE id = ?");
        $stmt->execute([$id]);

        if (!$stmt->rowCount()) {
            throw new NO_DATA_DELETED_EXCEPTION;
        }
    }

    public function getSeatsOfHall($id) {

        $stmt = $this->connect()->prepare("SELECT * FROM seats WHERE hall_id = ?");
        $stmt->execute([$id]);

        if ($stmt->rowCount()) {
            $res = array();
            while ($row = $stmt->fetch()) {
                array_push($res, new Seat($row['id'], $row['pos_x'], $row['pos_y'], $row['type'], $id));
            }
            return $res;
        }

        throw new NO_DATA_FOUND_EXCEPTION;
    }

    public function getProgramEntryNoData($id) {

        $stmt = $this->connect()->prepare("SELECT * FROM program_entries WHERE id = ?");
        $stmt->execute([$id]);

        if ($stmt->rowCount()) {
            while ($row = $stmt->fetch()) {
                return new ProgramEntry($row['id'], $row['start'], $row['price'], $row['movie_id'], $row['hall_id']);
            }
        }

        throw new NO_DATA_FOUND_EXCEPTION;
    }

    public function getProgramEntry($id) {

        $stmt = $this->connect()->prepare("SELECT `program_entries`.`id`, `start`, `price`, `movie_id`, `hall_id`, `uid`, `type`, `cinema_id`, `title`, `year`, `duration` FROM `program_entries` INNER JOIN `movies` ON `movie_id` = `movies`.`id` INNER JOIN `halls` ON `hall_id` = `halls`.`id` WHERE `program_entries`.`id` = ?");
        $stmt->execute([$id]);

        if ($stmt->rowCount()) {
            while ($row = $stmt->fetch()) {
                return new ProgramEntry($row['id'], $row['start'], $row['price'], new Movie($row['movie_id'], $row['title'], $row['year'], $row['duration'], "", ""), new Hall($row['hall_id'], $row['uid'], $row['type'], $row['cinema_id']));
            }
        }

        throw new NO_DATA_FOUND_EXCEPTION;
    }

    public function getOccupiedSeatsOfProgramEntry($id) {

        $stmt = $this->connect()->prepare("SELECT pos_x, pos_y, type FROM `seats` INNER JOIN `reserved_seats` ON `reserved_seats`.`seat_id` = `seats`.`id` INNER JOIN `reservations` ON `reserved_seats`.`reservation_id` = `reservations`.`id` WHERE `reservations`.`program_entry_id` = ?");
        $stmt->execute([$id]);

        if ($stmt->rowCount()) {
            $res = array();
            while ($row = $stmt->fetch()) {
                array_push($res, new Seat("", $row['pos_x'], $row['pos_y'], $row['type'], ""));
            }
            return $res;
        }

        throw new NO_DATA_FOUND_EXCEPTION;
    }

    public function getSeatIdsOfReservation($id) {

        $stmt = $this->connect()->prepare("SELECT seat_id FROM `reserved_seats` WHERE `reservation_id` = ?");
        $stmt->execute([$id]);

        if ($stmt->rowCount()) {
            $res = array();
            while ($row = $stmt->fetch()) {
                array_push($res, new Seat($row['seat_id'], "", "", "", ""));
            }
            return $res;
        }

        throw new NO_DATA_FOUND_EXCEPTION;
    }

    public function getSeatsOfCompletedReservation($id) {

        $stmt = $this->connect()->prepare("SELECT `confirmed_seats`.`seat_id`, `seats`.`pos_x`, `seats`.`pos_y`, `seats`.`type` FROM `confirmed_seats` INNER JOIN `seats` ON `confirmed_seats`.`seat_id` = `seats`.`id` WHERE `completed_reservation_id` = ?");
        $stmt->execute([$id]);

        if ($stmt->rowCount()) {
            $res = array();
            while ($row = $stmt->fetch()) {
                array_push($res, new Seat($row['seat_id'], $row['pos_x'], $row['pos_y'], $row['type'], ""));
            }
            return $res;
        }

        throw new NO_DATA_FOUND_EXCEPTION;
    }

    public function getConfirmedSeatsOfProgramEntry($id) {

        $stmt = $this->connect()->prepare("SELECT pos_x, pos_y, type FROM `seats` INNER JOIN `confirmed_seats` ON `confirmed_seats`.`seat_id` = `seats`.`id` INNER JOIN `completed_reservations` ON `confirmed_seats`.`completed_reservation_id` = `completed_reservations`.`id` WHERE `completed_reservations`.`program_entry_id` = ?");
        $stmt->execute([$id]);

        if ($stmt->rowCount()) {
            $res = array();
            while ($row = $stmt->fetch()) {
                array_push($res, new Seat("", $row['pos_x'], $row['pos_y'], $row['type'], ""));
            }
            return $res;
        }

        throw new NO_DATA_FOUND_EXCEPTION;
    }

    public function addOrder($reservations, $user) {
        /* echo "<pre>";
          var_dump($reservations);
          echo "</pre>";
          echo "<br>";
          echo "<pre>";
          var_dump($user);
          echo "</pre>"; */
        // Check seats
        foreach ($reservations as $reservation) {

            try {
                $reservedSeats = $this->getOccupiedSeatsOfProgramEntry($reservation->programEntryId);

                foreach ($reservedSeats as $rs) {
                    foreach ($reservation->seats as $s) {
                        if ($rs->posX == $s->posX && $rs->posY == $s->posY) {
                            throw new RESERVATION_FAILED_EXCEPTION;
                        }
                    }
                }
            } catch (NO_DATA_FOUND_EXCEPTION $e) {
                
            }
        }

        try {
            // Create Order
            $this->connect()->beginTransaction();
            $stmt1 = $this->connect()->prepare("INSERT INTO orders (id, user_id) VALUES (NULL, ?)");
            $stmt1->execute([$user->id]);
            $orderId = $this->connect()->lastInsertId();

            // Create Reservations

            foreach ($reservations as $reservation) {

                $stmt2 = $this->connect()->prepare("INSERT INTO reservations (id, order_id, program_entry_id) VALUES (NULL, ?, ?)");
                $stmt2->execute([$orderId, $reservation->programEntryId]);
                $reservationId = $this->connect()->lastInsertId();

                $programEntry = $this->getProgramEntryNoData($reservation->programEntryId);

                // Reserve Seats
                foreach ($reservation->seats as $seat) {

                    $stmt3 = $this->connect()->prepare("SELECT id FROM seats WHERE pos_x = ? AND pos_y = ? AND hall_id = ?");
                    $stmt3->execute([$seat->posX, $seat->posY, $programEntry->hall]);

                    $seatId = null;
                    if ($stmt3->rowCount()) {
                        while ($row = $stmt3->fetch()) {
                            $seatId = $row['id'];
                        }
                    }

                    if ($seatId == null) {
                        throw new PDOException;
                    }

                    $stmt4 = $this->connect()->prepare("INSERT INTO reserved_seats (id, reservation_id, seat_id) VALUES (NULL, ?, ?)");
                    $stmt4->execute([$reservationId, $seatId]);
                }
            }
            $this->connect()->commit();
        } catch (PDOException $e) {
            $this->connect()->rollback();
            throw new NO_DATA_ADDED_EXCEPTION;
        }
    }

    public function deleteOrder($id) {
        $stmt = $this->connect()->prepare("DELETE FROM orders WHERE id = ?");
        $stmt->execute([$id]);

        if (!$stmt->rowCount()) {
            throw new NO_DATA_DELETED_EXCEPTION;
        }
    }

    public function getActiveOrdersOfUser($userId) {

        $stmt = $this->connect()->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY created DESC");
        $stmt->execute([$userId]);

        if ($stmt->rowCount()) {
            $res = array();
            while ($row = $stmt->fetch()) {
                array_push($res, new Order($row['id'], $row['created'], $row['user_id']));
            }
            return $res;
        }

        throw new NO_DATA_FOUND_EXCEPTION;
    }

    public function getCompletedOrdersOfUser($userId) {

        $stmt = $this->connect()->prepare("SELECT * FROM completed_orders WHERE user_id = ? ORDER BY completed DESC");
        $stmt->execute([$userId]);

        if ($stmt->rowCount()) {
            $res = array();
            while ($row = $stmt->fetch()) {
                array_push($res, new CompletedOrder($row['id'], $row['created'], $row['completed'], $row['user_id']));
            }
            return $res;
        }

        throw new NO_DATA_FOUND_EXCEPTION;
    }

    public function getActiveOrder($id) {

        $stmt = $this->connect()->prepare("SELECT * FROM orders WHERE id = ?");
        $stmt->execute([$id]);

        if ($stmt->rowCount()) {
            while ($row = $stmt->fetch()) {
                return new Order($row['id'], $row['created'], $row['user_id']);
            }
        }
        throw new NO_DATA_FOUND_EXCEPTION;
    }

    public function getCompletedOrder($id) {

        $stmt = $this->connect()->prepare("SELECT * FROM completed_orders WHERE id = ?");
        $stmt->execute([$id]);

        if ($stmt->rowCount()) {
            while ($row = $stmt->fetch()) {
                return new CompletedOrder($row['id'], $row['created'], $row['completed'], $row['user_id']);
            }
        }
        throw new NO_DATA_FOUND_EXCEPTION;
    }

    public function getReservationsOfOrder($id) {

        $stmt = $this->connect()->prepare("SELECT reservations.id, reservations.program_entry_id, COUNT(reserved_seats.seat_id) AS count_seats FROM reservations JOIN reserved_seats ON reservations.id = reserved_seats.reservation_id WHERE reservations.order_id = ? GROUP BY reservations.id");
        $stmt->execute([$id]);

        if ($stmt->rowCount()) {
            $res = array();
            while ($row = $stmt->fetch()) {
                array_push($res, new Reservation($row['id'], $row['program_entry_id'], $row['count_seats']));
            }
            return $res;
        }

        throw new NO_DATA_FOUND_EXCEPTION;
    }

    public function getReservationsOfCompletedOrder($id) {

        $stmt = $this->connect()->prepare("SELECT completed_reservations.id, completed_reservations.price, completed_reservations.program_entry_id, COUNT(confirmed_seats.seat_id) AS count_seats FROM completed_reservations JOIN confirmed_seats ON completed_reservations.id = confirmed_seats.completed_reservation_id WHERE completed_reservations.completed_order_id = ? GROUP BY completed_reservations.id");
        $stmt->execute([$id]);

        if ($stmt->rowCount()) {
            $res = array();
            while ($row = $stmt->fetch()) {
                array_push($res, new CompletedReservation($row['id'], $row['price'], $row['program_entry_id'], $row['count_seats']));
            }
            return $res;
        }

        throw new NO_DATA_FOUND_EXCEPTION;
    }

    public function completeOrder($id) {

        $order = $this->getActiveOrder($id);
        $reservations = $this->getReservationsOfOrder($order->id);

        try {
            // Migrate Order
            $this->connect()->beginTransaction();
            $stmt1 = $this->connect()->prepare("INSERT INTO completed_orders (id, created, user_id) VALUES (NULL, ?, ?)");
            $stmt1->execute([$order->created, $order->userId]);
            $orderId = $this->connect()->lastInsertId();

            foreach ($reservations as $reservation) {

                $programEntry = $this->getProgramEntryNoData($reservation->programEntryId);

                // Migrate reservation
                $stmt2 = $this->connect()->prepare("INSERT INTO completed_reservations (id, price, completed_order_id, program_entry_id) VALUES (NULL, ?, ?, ?)");
                $stmt2->execute([$programEntry->price * $reservation->seats, $orderId, $reservation->programEntryId]);
                $reservationId = $this->connect()->lastInsertId();

                $seats = $this->getSeatIdsOfReservation($reservation->id);

                // Migrate reserved seats
                foreach ($seats as $seat) {
                    $stmt3 = $this->connect()->prepare("INSERT INTO confirmed_seats (id, completed_reservation_id, seat_id) VALUES (NULL, ?, ?)");
                    $stmt3->execute([$reservationId, $seat->id]);
                }
            }

            // Delete old order
            $this->deleteOrder($id);

            $this->connect()->commit();
            return $orderId;
        } catch (PDOException $e) {
            $this->connect()->rollback();
            throw new ORDER_CONFIRMATION_FAILED_EXCEPTION;
        } catch (NO_DATA_FOUND_EXCEPTION $e) {
            $this->connect()->rollback();
            throw new ORDER_CONFIRMATION_FAILED_EXCEPTION;
        } catch (NO_DATA_DELETED_EXCEPTION $e) {
            $this->connect()->rollback();
            throw new ORDER_CONFIRMATION_FAILED_EXCEPTION;
        }
    }

}
