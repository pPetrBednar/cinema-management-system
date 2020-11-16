<?php

class Order {

    public $id;
    public $created;
    public $userId;

    public function __construct($id, $created, $userId) {
        $this->id = $id;
        $this->created = $created;
        $this->userId = $userId;
    }

}
