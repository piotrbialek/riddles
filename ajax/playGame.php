<?php

session_start();

include("../../projekt/notLoggedRedirect.php");
include("../admin/includes/Move.php");
include("../admin/includes/Game.php");
include("../admin/includes/Player.php");
include("../admin/includes/Riddle.php");

$userId = $_SESSION['id'];

if (!isset($_POST['game_id'])) {
    header('Location: ../../projekt/games.php');
    exit();
} else {
    $gameId = $_POST['game_id'];

    $player = Player::findGamePlayerId($userId, $gameId);
    $move = Move::findOpponentsMove($gameId, $player->id);

    if ($move) {
        echo $move->riddle_id;
    } else echo 0;
}



