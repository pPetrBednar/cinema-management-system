<?php

class Cinema {

    public $id;
    public $title;
    public $city;
    public $address;
    public $coverUrl;

    public function __construct($id, $title, $city, $address, $coverUrl) {
        $this->id = $id;
        $this->title = $title;
        $this->city = $city;
        $this->address = $address;
        $this->coverUrl = $coverUrl;
    }

}
