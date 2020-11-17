<?php

class CompletedOrder {

    public $id;
    public $created;
    public $completed;
    public $userId;

    public function __construct($id, $created, $completed, $userId) {
        $this->id = $id;
        $this->created = $created;
        $this->completed = $completed;
        $this->userId = $userId;
    }

}
