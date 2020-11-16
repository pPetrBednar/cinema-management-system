<?php

class ProgramEntry {

    public $id;
    public $start;
    public $price;
    public $movie;
    public $hall;

    public function __construct($id, $start, $price, $movie, $hall) {
        $this->id = $id;
        $this->start = $start;
        $this->price = $price;
        $this->movie = $movie;
        $this->hall = $hall;
    }

}
