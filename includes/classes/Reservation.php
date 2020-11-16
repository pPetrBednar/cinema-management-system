<?php

class Reservation {

    public $id;
    public $programEntryId;
    public $seats;

    public function __construct($id, $programEntryId, $seats) {
        $this->id = $id;
        $this->programEntryId = $programEntryId;
        $this->seats = $seats;
    }

}
