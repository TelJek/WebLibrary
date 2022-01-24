<?php
require_once "Dto.php";

$title = $_POST["title"];
$grade = $_POST["grade"];
$isRead = $_POST["isRead"];
$author1_id = $_POST["author1"];
$author2_id = $_POST["author2"];

if (strlen($title) < 3) {
    header("Location: ..\index.php?command=show_book_form&input=error&title=$title&grade=$grade&isRead=$isRead");
    exit();
}
if (strlen($title) > 23) {
    header("Location: ..\index.php?command=show_book_form&input=error&title=$title&grade=$grade&isRead=$isRead");
    exit();
}

$dto = new Dto();
$dto->addData("book", [$title, intval($grade), $isRead, intval($author1_id), intval($author2_id)]);

header("Location: ..?command=show_book_list&input=addSuccess");