<?php

class ProgramEntry {

    public $id;
    public $start;
    public $movie;
    public $hall;

    public function __construct($id, $start, $movie, $hall) {
        $this->id = $id;
        $this->start = $start;
        $this->movie = $movie;
        $this->hall = $hall;
    }

}
