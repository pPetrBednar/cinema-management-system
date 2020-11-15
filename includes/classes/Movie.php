<?php

class Movie {

    public $id;
    public $title;
    public $year;
    public $duration;
    public $description;
    public $coverUrl;

    public function __construct($id, $title, $year, $duration, $description, $coverUrl) {
        $this->id = $id;
        $this->title = $title;
        $this->year = $year;
        $this->duration = $duration;
        $this->description = $description;
        $this->coverUrl = $coverUrl;
    }

}
