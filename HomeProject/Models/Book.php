<?php

class Book {

    public int $id;
    public string $title;
    public ?int $grade;
    public ?bool $isRead;
    public array $authors = [];

    public function __construct(int $id, string $title, ?int $grade, ?bool $isRead) {
        $this->id = $id;
        $this->title = $title;
        $this->grade = $grade;
        $this->isRead = $isRead;
    }

    public function addAuthor($author) {
        $this->authors[] = $author;
    }
    public function toString(): string
    {
        return $this->title;
    }
}
