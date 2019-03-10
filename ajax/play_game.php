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

    $player=Player::findGamePlayerId($user_id,$game_id);
    $move=Move::findOpponentsMove($game_id, $player->id);

    if($move){
        echo $move->riddle_id;
    }else echo 0;
}



