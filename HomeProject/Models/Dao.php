<?php

class Dao {

    function getBooksFromDb() {
        $conn = getConnection();

        $createTable = $conn->prepare('CREATE TABLE IF NOT EXISTS books (id INTEGER PRIMARY KEY AUTO_INCREMENT, title VARCHAR(50),grade INTEGER, isRead VARCHAR(25), author1_id INTEGER, author2_id INTEGER);');

        $createTable->execute();

        $stmt = $conn->prepare('SELECT b.id, b.title, b.grade, b.author1_id, a1.firstName, a1.lastName, b.author2_id, a2.firstName, a2.lastName
                                    from books b
                                            left join authors a1
                                                    on b.author1_id = a1.id
                                            left join authors a2
                                                    on b.author2_id = a2.id');

        $stmt->execute();

        return $stmt;
    }

    function getAuthorsFromDb() {
        $conn = getConnection();

        $createTable = $conn->prepare('CREATE TABLE IF NOT EXISTS authors (id INTEGER PRIMARY KEY AUTO_INCREMENT, firstName VARCHAR(50),lastName VARCHAR(50),grade INTEGER);');

        $createTable->execute();

        $stmt = $conn->prepare('SELECT id, firstName, lastName, grade from authors a');

        $stmt->execute();

        return $stmt;
    }

    function saveDataInDb($dataType, $dataToSave) {
        $conn = getConnection();

        if ($dataType === "book") {
            $createTable = $conn->prepare('CREATE TABLE IF NOT EXISTS books (id INTEGER PRIMARY KEY AUTO_INCREMENT, title VARCHAR(50),grade INTEGER, isRead VARCHAR(25), author1_id INTEGER, author2_id INTEGER);');

            $createTable->execute();

            $stmt = $conn->prepare('INSERT INTO books (title, grade, isRead, author1_id, author2_id) VALUES (:title, :grade, :isRead, :author1, :author2);');

            $stmt->bindValue(':title', $dataToSave[0]);
            $stmt->bindValue(':grade', $dataToSave[1]);
            $stmt->bindValue(':isRead', $dataToSave[2]);
            $stmt->bindValue(':author1', $dataToSave[3]);
            $stmt->bindValue(':author2', $dataToSave[4]);

            $stmt->execute();
        }

        if ($dataType === "author") {
            $createTable = $conn->prepare('CREATE TABLE IF NOT EXISTS authors (id INTEGER PRIMARY KEY AUTO_INCREMENT, firstName VARCHAR(50),lastName VARCHAR(50),grade INTEGER);');

            $createTable->execute();

            $stmt = $conn->prepare('INSERT INTO authors (firstName, lastName, grade) VALUES (:firstName, :lastName, :grade);');

            $stmt->bindValue(':firstName', $dataToSave[0]);
            $stmt->bindValue(':lastName', $dataToSave[1]);
            $stmt->bindValue(':grade', $dataToSave[2]);

            $stmt->execute();
        }
    }

    function getDataByTypeAndIdFromDb($dataType, $searchedId) {
        $conn = getConnection();

        if ($dataType === "book") {

            $stmt = $conn->prepare('SELECT b.id, b.title, b.grade, b.isRead, b.author1_id, b.author2_id
                                    from books b 
                                    left join authors a 
                                        on b.author1_id = a.id and b.author2_id = a.id
                                        where b.id = (:searchedId)');

            $stmt->bindValue(':searchedId', "$searchedId");

            $stmt->execute();

            return $stmt;

        }
        if ($dataType === "author") {

            $stmt = $conn->prepare('SELECT id, firstName, lastName, grade FROM authors WHERE id = (:id)');

            $stmt->bindValue(':id', $searchedId);

            $stmt->execute();

            return $stmt;
        }
        return "DataType: " . $dataType . " is unknown. Use 'book' or 'author' as DataType.";
    }

    function updateDataByTypeAndIdInDb($dataType, $dataToUpdate) {
        $conn = getConnection();

        if ($dataType === "book") {
            $stmt = $conn->prepare("UPDATE books SET title=(:title), grade=(:grade), isRead=(:isRead), author1_id=(:author1), author2_id=(:author2) WHERE id=$dataToUpdate[0]");

            $stmt->bindValue(':title', $dataToUpdate[1]);
            $stmt->bindValue(':grade', $dataToUpdate[2]);
            $stmt->bindValue(':isRead', $dataToUpdate[3]);
            $stmt->bindValue(':author1', $dataToUpdate[4]);
            $stmt->bindValue(':author2', $dataToUpdate[5]);

            $stmt->execute();
        }

        if ($dataType === "author") {
            $stmt = $conn->prepare("UPDATE authors SET firstName=(:firstName), lastName=(:lastName), grade=(:grade) WHERE id=$dataToUpdate[0]");

            $stmt->bindValue(':firstName', $dataToUpdate[1]);
            $stmt->bindValue(':lastName', $dataToUpdate[2]);
            $stmt->bindValue(':grade', $dataToUpdate[3]);

            $stmt->execute();
        }
    }

    function deleteDataById($dataType, $dataId) {
        if ($dataType === "book") {
            $conn = getConnection();

            $stmt = $conn->prepare("DELETE FROM books WHERE id=(:id)");

            $stmt->bindValue(':id', $dataId);

            $stmt->execute();
        }
        if ($dataType === "author") {
            $conn = getConnection();

            $stmt = $conn->prepare("DELETE FROM authors WHERE id=(:id)");

            $stmt->bindValue(':id', $dataId);

            $stmt->execute();
        }
    }
}

