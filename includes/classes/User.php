<?php

/**
 * User Data Holder
 */
class User {

    public $email;
    public $firstName;
    public $lastName;
    public $permission;
    public $registered;

    public function __construct($email, $firstName, $lastName, $permission, $registered) {
        $this->email = $email;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->permission = $permission;
        $this->registered = $registered;
    }
}
