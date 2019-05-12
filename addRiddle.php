<?php
header('Content-T: text/html; charset=UTF-8');

session_start();

include("../projekt/notLoggedRedirect.php");
include_once("admin/includes/Riddle.php");
include_once("admin/includes/Game.php");
include_once("admin/includes/Move.php");

if (isset($_POST['riddle'])) {
    include "validateRiddle.php";
    if ($validation) {
        $category = mb_strtoupper($category, 'UTF-8');
        $description = mb_strtoupper($description, 'UTF-8');
        $riddle = mb_strtoupper($riddle, 'UTF-8');

        $newRiddle = new Riddle();
        $newRiddle->category = $category;
        $newRiddle->description = $description;
        $newRiddle->riddle = $riddle;
        $newRiddle->riddle_level = $riddle_level;
        $newRiddle->author_id = $id;
        $newRiddle->accepted = 0;
        $newRiddle->solved = 0;
        $newRiddle->in_match = 0;

        if ($newRiddle->save()) {
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

            $_SESSION['riddle_added'] = 'Riddle has been added <span class="glyphicon glyphicon-check green"></span>';
        } else $_SESSION['riddle_added'] = 'There was a problem with adding riddle';
    }
}