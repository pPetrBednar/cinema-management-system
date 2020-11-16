<?php

/**
 * User Data Holder
 */
class User {

    public $id;
    public $email;
    public $firstName;
    public $lastName;
    public $permission;
    public $registered;

    public function __construct($id, $email, $firstName, $lastName, $permission, $registered) {
        $this->id = $id;
        $this->email = $email;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->permission = $permission;
        $this->registered = $registered;
    }

}
