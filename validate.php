<?php
$validation = true;

$category = $_POST['category'];
$description = $_POST['description'];
$riddle = $_POST['riddle'];
$riddleLevel = $_POST['riddleLevel'];
$login = $_SESSION['login'];
$id = $_SESSION['id'];

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

if ($riddleLevel > 20 || $riddleLevel < 0) {
    $validation = false;
    $_SESSION['info_riddleLevel'] = "Level must be between 0 and 20!";
}

if ($riddleLevel == '' || $riddleLevel == ' ') {
    $validation = false;
    $_SESSION['info_riddleLevel'] = "Level could not be empty!";
}

$_SESSION['temp_category'] = $category;
$_SESSION['temp_description'] = $description;
$_SESSION['temp_riddle'] = $riddle;
$_SESSION['temp_riddleLevel'] = $riddleLevel;