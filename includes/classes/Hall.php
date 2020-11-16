<?php

class Hall {

    public $id;
    public $uid;
    public $type;
    public $cinemaId;

    public function __construct($id, $uid, $type, $cinemaId) {
        $this->id = $id;
        $this->uid = $uid;
        $this->type = $type;
        $this->cinemaId = $cinemaId;
    }

}
