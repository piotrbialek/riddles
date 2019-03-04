<?php
include("../admin/includes/Riddle.php");
include("../admin/includes/Move.php");
session_start();
if (isset($_POST['riddle'])) {




    include "../../projekt/validateRiddle.php";

    $author_id=$_SESSION['id'];

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
        $createRiddle = new Riddle();
        if(isset($_POST['riddle_id'])) {
            $riddle_id = $_POST['riddle_id'];
            $createRiddle->id = $riddle_id;
        }
        $createRiddle->category = $category;
        $createRiddle->description = $description;
        $createRiddle->riddle = $riddle;
        $createRiddle->riddle_level = $riddle_level;
        $createRiddle->author_id = $author_id;
        $createRiddle->accepted = $accepted;
        $createRiddle->in_match = 1;

        if ($createRiddle->save()) {

            $move=new Move();
            $move->game_id=$_POST['game_id'];
            $move->player_id=$author_id;
            $move->riddle_id=$createRiddle->id;
            if($move->save()) echo 1;
            else echo "There was a problem with saving riddle.";


        }else echo "There was a problem with creating riddle.";
    }else echo "The data entered is not correct.";
}