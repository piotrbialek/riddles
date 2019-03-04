<?php

session_start();

include("../../projekt/notLoggedRedirect.php");
include("../admin/includes/Move.php");
include("../admin/includes/Game.php");
include("../admin/includes/Player.php");
include("../admin/includes/Riddle.php");

$user_id = $_SESSION['id'];

if (!isset($_POST['game_id'])) {
    header('Location: ../../projekt/games.php');
    exit();
}else {
    $game_id = $_POST['game_id'];

    $move=Move::findOpponentsMove($game_id, $user_id);

    if($move){
        $toggleSolvedRiddle=Riddle::findById($move->riddle_id);
        $toggleSolvedRiddle->solved=1;
        if($toggleSolvedRiddle->save()) echo $move->riddle_id;
        else echo 0;
    }else echo 0;

}



