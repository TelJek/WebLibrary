<?php

require_once 'HomeProject/vendor/tpl.php';
require_once 'HomeProject/Models/Request.php';
require_once "HomeProject/Dto.php";
require_once 'HomeProject/Models/Book.php';
require_once 'HomeProject/Models/Author.php';

$request = new Request($_REQUEST);

$cmd = $request->param('command')
    ? $request->param('command')
    : 'show_book_list';


if ($cmd === 'show_book_list') {
    $dto = new Dto();
    $books = $dto->getData("books");
    $input = $request->param('input')
        ? $request->param('input')
        : null;

    $message = "";
    if ($input == "addSuccess") $message = "Lisatud!";
    if ($input == "editSuccess") $message = "Uuendatud!";
    if ($input == "deleteSuccess") $message = "Kustutatud!";

    $dataBookList = [
        'template' => 'book_list.html',
        'bodyId' => 'book-list-page',
        'books' => $books,
        'message' =>$message
    ];

    print renderTemplate('HomeProject/tpl/main.html', $dataBookList);
} else if ($cmd === 'show_author_list') {
    $input = $request->param('input')
        ? $request->param('input')
        : null;

    $message = "";
    if ($input == "addSuccess") $message = "Lisatud!";
    if ($input == "editSuccess") $message = "Uuendatud!";
    if ($input == "deleteSuccess") $message = "Kustutatud!";

    $dto = new Dto();
    $authors = $dto->getData("authors");
    $dataAuthorList = [
        'template' => 'author_list.html',
        'bodyId' => 'author-list-page',
        'authors' => $authors,
        'message' =>$message
    ];

    print renderTemplate('HomeProject/tpl/main.html', $dataAuthorList);
} else if ($cmd === 'show_book_form') {
    $error = $request->param('input')
        ? "Pealkiri peab olema 3 kuni 23 märki!"
        : null;
    $title = $request->param('title')
        ? $request->param('title')
        : null;
    $grade = $request->param('grade')
        ? $request->param('grade')
        : null;
    $isRead = $request->param('isRead')
        ? $request->param('isRead')
        : null;

    $dto = new Dto();
    $authors = $dto->getData("authors");
    $dataBookForm = [
        'template' => 'book_add.html',
        'bodyId' => 'book-form-page',
        'authors' => $authors,
        'error' => $error,
        'bookTitle' => $title,
        'bookGrade' => $grade,
        'isRead' => $isRead
    ];

    print renderTemplate('HomeProject/tpl/main.html', $dataBookForm);
} else if ($cmd === 'show_book_edit_form') {

    $id = $request->param('id')
        ? $request->param('id')
        : null;
    $error = $request->param('input')
        ? "Pealkiri peab olema 3 kuni 23 märki!"
        : null;
    $title = $request->param('title')
        ? $request->param('title')
        : null;
    $grade = $request->param('grade')
        ? $request->param('grade')
        : null;
    $isRead = $request->param('isRead')
        ? $request->param('isRead')
        : null;

    $dto = new Dto();
    $authors = $dto->getData("authors");

    $bookById = $dto->getDataById("book", $id);

    $dataBookFormEdit = [
        'template' => 'book_edit.html',
        'bookById' => $bookById,
        'authors' => $authors,
        'error' => $error,
        'bookTitle' => $title,
        'bookGrade' => $grade,
        'isRead' => $isRead
    ];

    print renderTemplate('HomeProject/tpl/main.html', $dataBookFormEdit);
} else if ($cmd === 'show_author_form') {
    $input = $request->param('input')
        ? $request->param('input')
        : null;

    $error = '';
    if ($input == "errorFirstName") $error = "Eesnimi peab olema 1 kuni 21 märki!";
    if ($input == "errorLastName") $error = "Perekonnanimi peab olema 2 kuni 22 märki!";

    $firstName = $request->param('firstName')
        ? $request->param('firstName')
        : null;
    $lastName = $request->param('lastName')
        ? $request->param('lastName')
        : null;
    $grade = $request->param('grade')
        ? $request->param('grade')
        : null;

    $dataBookForm = [
        'template' => 'author_add.html',
        'bodyId' => 'author-form-page',
        'error' => $error,
        'firstName' => $firstName,
        'lastName' => $lastName,
        'authorGrade' => $grade
    ];

    print renderTemplate('HomeProject/tpl/main.html', $dataBookForm);
} else if ($cmd === 'show_author_edit_form') {
    $input = $request->param('input')
        ? $request->param('input')
        : null;

    $error = '';
    if ($input == "errorFirstName") $error = "Eesnimi peab olema 1 kuni 21 märki!";
    if ($input == "errorLastName") $error = "Perekonnanimi peab olema 2 kuni 22 märki!";

    $id = $request->param('id')
        ? $request->param('id')
        : null;
    var_dump($request->param('lastName'));
    $firstName = $request->param('firstName')
        ? $request->param('firstName')
        : null;
    $lastName = $request->param('lastName')
        ? $request->param('lastName')
        : null;
    $authorGrade = $request->param('grade')
        ? $request->param('grade')
        : null;

    $dto = new Dto();
    $authorById = $dto->getDataById("author" ,$id);

    $dataBookForm = [
        'template' => 'author_edit.html',
        'error' => $error,
        'firstName' => $firstName,
        'lastName' => $lastName,
        'authorGrade' => $authorGrade,
        'authorById'=> $authorById
    ];

    print renderTemplate('HomeProject/tpl/main.html', $dataBookForm);
}