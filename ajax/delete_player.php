<?php

session_start();

include("../../projekt/notLoggedRedirect.php");
include("../admin/includes/Game.php");
include("../admin/includes/Player.php");

$user_id = $_SESSION['id'];

if (!isset($_POST['player_id'])) {
    header('Location: ../../projekt/games.php');
    exit();
} else {
    $player_id = $_POST['player_id'];
    if($player_id>0) {
        $player = Player::findById($player_id);

        if ($player->delete()) {
            echo 1;
        } else {
            echo "There was a problem with deleting player.";
        }
    } else echo $player_id;
}



