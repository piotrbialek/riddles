<?php

session_start();

include("../../projekt/notLoggedRedirect.php");
include("../admin/includes/Game.php");
include("../admin/includes/Player.php");

$user_id = $_SESSION['id'];

if (!isset($_POST['game_id']) || !isset($_POST['player_id'])) {
    header('Location: ../../projekt/games.php');
    exit();
}else {
    $initiator_id = $_POST['player_id'];
    $game_id = $_POST['game_id'];

    if ($user_id != $initiator_id) {

        $game=Game::findById($game_id);

        $player=new Player();
        $player->user_id=$user_id;
        $player->game_id=$game->id;

        if ($player->save()) {
            echo 1;
        } else {
            echo "There was a problem with joining game.";
        }

    } else {
        echo "You can't join your own game.";
    }
}



