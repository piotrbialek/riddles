<?php
$validation = true;

$id = $_SESSION['id'];
$login = $_SESSION['login'];

$category = mb_strtoupper($_POST['category'], 'UTF-8');
$description = mb_strtoupper($_POST['description'], 'UTF-8');
$riddle = mb_strtoupper($_POST['riddle'], 'UTF-8');
$riddle_level = $_POST['riddle_level'];

if (isset($_POST['author_id'])) $author_id = $_POST['author_id']; // multiplayer

if ((strlen($category) < 3) || (strlen($category) > 20)) {
    $validation = false;
    $_SESSION['info_category'] = "Category must be between 3 and 20 characters!";
}

if ((strlen($description) < 3) || (strlen($description) > 60)) {
    $validation = false;
    $_SESSION['info_description'] = "Description must be between 3 and 60 characters!";
}

if ((strlen($riddle) < 3) || (strlen($riddle) > 60)) {
    $validation = false;
    $_SESSION['info_riddle'] = "Riddle must be between 3 and 60 characters!";
}

if (!preg_match("/^[a-zA-ZżźćńółęąśŻŹĆŃÓŁĘĄŚ ]+$/", $category) == 1) {
    $validation = false;
    $_SESSION['info_category'] = "Category can only consist of letters!";
}

if (!preg_match("/^[a-zA-ZżźćńółęąśŻŹĆŃÓŁĘĄŚ ?.,]+$/", $description) == 1) {
    $validation = false;
    $_SESSION['info_description'] = "Description contains inappropriate characters!";
}

if (!preg_match("/^[a-zA-ZżźćńółęąśŻŹĆŃÓŁĘĄŚ ]+$/", $riddle) == 1) {
    $validation = false;
    $_SESSION['info_riddle'] = "Riddle can only consist of letters!";
}

if ($riddle_level > 100 || $riddle_level < 1) {
    $validation = false;
    $_SESSION['info_riddle_level'] = "Level must be between 1 and 100!";
}

if ($riddle_level == '' || $riddle_level == ' ') {
    $validation = false;
    $_SESSION['info_riddle_level'] = "Level could not be empty!";
}

$_SESSION['temp_category'] = $category;
$_SESSION['temp_description'] = $description;
$_SESSION['temp_riddle'] = $riddle;
$_SESSION['temp_riddle_level'] = $riddle_level;
