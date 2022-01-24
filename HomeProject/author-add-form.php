<?php
require_once "Dto.php";
require_once __DIR__ . '/connection.php';

$firstName = $_POST["firstName"];
$lastName = $_POST["lastName"];
$grade = $_POST["grade"];

if (strlen($firstName) < 1) {
    header("Location: ../index.php?command=show_author_form&input=errorFirstName&firstName=$firstName&lastName=$lastName&grade=$grade");
    exit();
}
if (strlen($firstName) > 21) {
    header("Location: ../index.php?command=show_author_form&input=errorFirstName&firstName=$firstName&lastName=$lastName&grade=$grade");
    exit();
}

if (strlen($lastName) < 2) {
    header("Location: ../index.php?command=show_author_form&input=errorLastName&firstName=$firstName&lastName=$lastName&grade=$grade");
    exit();
}
if (strlen($lastName) > 22) {
    header("Location: ../index.php?command=show_author_form&input=errorLastName&firstName=$firstName&lastName=$lastName&grade=$grade");
    exit();
}

$dto = new Dto();
$dto->addData("author", [$firstName, $lastName, intval($grade)]);

header('Location: ..?command=show_author_list&input=addSuccess');