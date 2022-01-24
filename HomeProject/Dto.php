<?php

require_once __DIR__ . '/connection.php';
require_once __DIR__ . "/Models/Book.php";
require_once __DIR__ . "/Models/Author.php";
require_once __DIR__ . "/Models/Dao.php";

class Dto {
    function getData($dataType) {
        $dao = new Dao();

        if ($dataType === "books") {
            $stmt = $dao->getBooksFromDb();

            $books = [];

            foreach ($stmt as $row) {

                $id = $row['id'];
                $bookTitle = urldecode($row['title']);
                $bookGrade = urldecode($row['grade']);
                $author1FirstName = urldecode($row[7]);
                $author1LastName = urldecode($row[8]);
                $author2FirstName = urldecode($row[4]);
                $author2LastName = urldecode($row[5]);

                $book = new Book($id, $bookTitle, $bookGrade, null);
                if ($author1FirstName) {
                    $book->addAuthor(new Author($row['author1_id'], $author1FirstName, $author1LastName, null));
                }
                if ($author2FirstName) {
                    $book->addAuthor(new Author($row['author2_id'], $author2FirstName, $author2LastName, null));
                }

                $books[] = $book;
            }
            return $books;
        }

        if ($dataType == "authors") {
            $stmt = $dao->getAuthorsFromDb();

            $authors = [];

            foreach ($stmt as $row) {
                $id = $row['id'];
                $firstName = urldecode($row['firstName']);
                $lastName = urldecode($row['lastName']);
                $grade = urldecode($row['grade']);

                $author = new Author($id, $firstName, $lastName, $grade);

                $authors[] = $author;

            }
            return $authors;
        }
        return "Data with DataType: " . $dataType . " was not found. Use 'books' or 'authors' as DataType.";
    }

    function addData($dataType, $dataToAdd) {
        $dao = new Dao();

        $safeDataToAdd = [];

        foreach ($dataToAdd as $data) {
            if (strpos($data, "id")!== false) {
                $safeDataToAdd[] = $data;
            }
            $safeDataToAdd[] = urlencode($data);
        }

        $dao->saveDataInDb($dataType, $safeDataToAdd);
    }

    function updateDataById($dataType, $dataToUpdate) {
        $dao = new Dao();

        $safeDataToUpdate = [];

        foreach ($dataToUpdate as $data) {
            if (strpos($data, "id")!== false) {
                $safeDataToUpdate[] = $data;
            }
            $safeDataToUpdate[] = urlencode($data);
        }

        $dao->updateDataByTypeAndIdInDb($dataType, $safeDataToUpdate);
    }

    function getDataById($dataType, $searchedId)
    {
        $dao = new Dao();

        $stmt = $dao->getDataByTypeAndIdFromDb($dataType, $searchedId);

        if ($dataType === "book") {
            foreach ($stmt as $row) {

                $id = $row['id'];
                $bookTitle = urldecode($row['title']);
                $bookGrade = urldecode($row['grade']);
                $isBookRead = urldecode($row['isRead']);
                $author1Id = $row['author1_id'];
                $author2Id = $row['author2_id'];

                $bookAuthor1 = $dao->getDataByTypeAndIdFromDb("author", $author1Id);
                $bookAuthor2 = $dao->getDataByTypeAndIdFromDb("author", $author2Id);

                $book = new Book($id, $bookTitle, $bookGrade, $isBookRead);

                foreach ($bookAuthor1 as $authorRow) {
                    $book->addAuthor(new Author($authorRow["id"], urldecode($authorRow["firstName"]), urldecode($authorRow["lastName"]), $authorRow["grade"]));
                }

                foreach ($bookAuthor2 as $authorRow) {
                    $book->addAuthor(new Author($authorRow["id"], urldecode($authorRow["firstName"]), urldecode($authorRow["lastName"]), $authorRow["grade"]));
                }

            }

            return $book;
        }

        if ($dataType === "author") {
            $stmt = $dao->getDataByTypeAndIdFromDb("author", $searchedId);

            foreach ($stmt as $row) {
                $foundId = $row['id'];
                $foundFirstName = urldecode($row['firstName']);
                $foundLastName = urldecode($row['lastName']);
                $foundGrade = urldecode($row['grade']);

                $author = new Author($foundId, $foundFirstName, $foundLastName, $foundGrade);

                $authors[] = $author;
            }

            return $author;
        }
        return "DataType: " . $dataType . " is unknown. Use 'book' or 'author' as DataType.";
    }

    function deleteDataById($dataType, $idToDelete)
    {
        $dao = new Dao();

        $dao->deleteDataById($dataType, $idToDelete);
    }
}