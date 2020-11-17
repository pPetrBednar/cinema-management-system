<?php

class Seat {

    public $id;
    public $posX;
    public $posY;
    public $type;
    public $hallId;

    public function __construct($id, $posX, $posY, $type, $hallId) {
        $this->id = $id;
        $this->posX = $posX;
        $this->posY = $posY;
        $this->type = $type;
        $this->hallId = $hallId;
    }

}
