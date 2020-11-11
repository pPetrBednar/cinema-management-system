<?php

/**
 * User Data Holder
 */
class User {

    public $email;
    public $firstname;
    public $lastname;
    public $registered;

    public function __construct($email, $firstname, $lastname, $registered) {
        $this->email = $email;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->registered = $registered;
    }
}
