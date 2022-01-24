<?php
require_once "Dto.php";

$id = $_POST["id"];
$firstName = $_POST["firstName"];
$lastName = $_POST["lastName"];
$grade = $_POST["grade"];

var_dump($lastName);

if (strlen($firstName) < 1) {
    header("Location: ..\index.php?command=show_author_edit_form&id=$id&input=errorFirstName&firstName=$firstName&lastName=$lastName&grade=$grade");
    exit();
}
if (strlen($firstName) > 21) {
    header("Location: ..\index.php?command=show_author_edit_form&id=$id&input=errorFirstName&firstName=$firstName&lastName=$lastName&grade=$grade");
    exit();
}

if (strlen($lastName) < 2) {
    header("Location: ..\index.php?command=show_author_edit_form&id=$id&input=errorLastName&firstName=$firstName&lastName=$lastName&grade=$grade");
    exit();
}
if (strlen($lastName) > 22) {
    header("Location: ..\index.php?command=show_author_edit_form&id=$id&input=errorLastName&firstName=$firstName&lastName=$lastName&grade=$grade");
    exit();
}

$dto = new Dto();

if ($_POST['submitButton'] == 'Salvesta') {
    $dto->updateDataById("author", [$id, $firstName, $lastName, $grade]);
    header("Location: ..?command=show_author_list&input=editSuccess");
}
if ($_POST['deleteButton'] == 'Kustuta') {
    $dto->deleteDataById("author", $id);
    header("Location: ..?command=show_author_list&input=deleteSuccess");
}
