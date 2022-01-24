<?php

class Author {

    public int $id;
    public string $firstName;
    public string $lastName;
    public ?int $grade;

    public function __construct($id, $firstName, $lastName, ?int $grade) {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->grade = $grade;
    }

}
