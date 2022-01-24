<?php
require_once "Dto.php";

$id = $_POST["id"];
$title = $_POST["title"];
$grade = $_POST["grade"];
$isRead = $_POST["isRead"];
$author1_id = $_POST["author1"];
$author2_id = $_POST["author2"];

var_dump($title);

if (strlen($title) < 3) {
    header("Location: ..\index.php?command=show_book_edit_form&id=$id&input=error&title=$title&grade=$grade&isRead=$isRead");
    exit();
}
if (strlen($title) > 23) {
    header("Location: ..\index.php?command=show_book_edit_form&id=$id&input=error&title=$title&grade=$grade&isRead=$isRead");
    exit();
}

$dto = new Dto();

if ($_POST['submitButton'] == 'Salvesta') {
    $dto->updateDataById("book", [$id, $title, intval($grade), $isRead, intval($author1_id), intval($author2_id)]);
    header("Location: ..?command=show_book_list&input=editSuccess");
}
if ($_POST['deleteButton'] == 'Kustuta') {
    $dto->deleteDataById("book", $id);
    header("Location: ..?command=show_book_list&input=deleteSuccess");
}

