<?php

session_start();

include("../../projekt/notLoggedRedirect.php");
include("../admin/includes/Game.php");
include("../admin/includes/Player.php");

$user_id = $_SESSION['id'];

if (!isset($_POST['create'])) {
    header('Location: ../../projekt/games.php');
    exit();
} else {
    $game = new Game();
    $game->player_started_id = $user_id;
    if ($game->save()) {

        $player=new Player();
        $player->user_id=$user_id;
        $player->game_id=$game->id;

        if ($player->save()) {
            echo $game->id;
        } else {
            echo "There was a problem with creating player.";
        }
    } else {
        echo "There was a problem with creating game.";
    }
}



