<?php

class CompletedReservation {

    public $id;
    public $price;
    public $programEntryId;
    public $seats;

    public function __construct($id, $price, $programEntryId, $seats) {
        $this->id = $id;
        $this->price = $price;
        $this->programEntryId = $programEntryId;
        $this->seats = $seats;
    }

}
