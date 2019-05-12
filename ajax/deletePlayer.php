<?php
session_start();

include("../../projekt/notLoggedRedirect.php");
include("../admin/includes/Game.php");
include("../admin/includes/Player.php");

if (!isset($_POST['player_id'])) {
    header('Location: ../../projekt/games.php');
    exit();
} else {
    $playerId = $_POST['player_id'];
    if($playerId>0) {
        $player = Player::findById($playerId);

        if ($player->delete()) {
            echo 1;
        } else {
            echo "There was a problem with deleting player.";
        }
    } else echo $playerId;
}



