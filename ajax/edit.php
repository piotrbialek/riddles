<?php
include("../admin/includes/Riddle.php");
session_start();
if (isset($_POST['riddle'])) {




    include "../../projekt/validateRiddle.php";

    if (isset($_SESSION['category'])) unset($_SESSION['category']);
    if (isset($_SESSION['description'])) unset($_SESSION['description']);
    if (isset($_SESSION['riddle'])) unset($_SESSION['riddle']);
    if (isset($_SESSION['info_category'])) unset($_SESSION['info_category']);
    if (isset($_SESSION['info_description'])) unset($_SESSION['info_description']);
    if (isset($_SESSION['info_riddle'])) unset($_SESSION['info_riddle']);
    if (isset($_SESSION['info_riddle_level'])) unset($_SESSION['info_riddle_level']);
    if (isset($_SESSION['temp_category'])) unset($_SESSION['temp_category']);
    if (isset($_SESSION['temp_description'])) unset($_SESSION['temp_description']);
    if (isset($_SESSION['temp_riddle'])) unset($_SESSION['temp_riddle']);
    if (isset($_SESSION['temp_riddle_level'])) unset($_SESSION['temp_riddle_level']);

    if ($validation) {
        $riddle_id = $_POST['riddle_id'];
        $updateRiddle = Riddle::findById($riddle_id);
        $updateRiddle->category = $category;
        $updateRiddle->description = $description;
        $updateRiddle->riddle = $riddle;
        $updateRiddle->riddle_level = $riddle_level;

        if ($updateRiddle->save()) {
            echo 1;
        }else echo 2;
    }else echo 0;
}