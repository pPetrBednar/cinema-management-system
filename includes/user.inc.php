<?php

/**
 * User Data Holder
 */
class User {

    public $email;
    public $firstname;
    public $lastname;
    public $permission;
    public $registered;

    public function __construct($email, $firstname, $lastname, $permission, $registered) {
        $this->email = $email;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->permission = $permission;
        $this->registered = $registered;
    }
}
