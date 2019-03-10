<?php

session_start();

include("../../projekt/notLoggedRedirect.php");
include("../admin/includes/Riddle.php");

$admin = $_SESSION['admin'];

if (!isset($_POST['riddle_id'])) {
    header('Location: ../../projekt/mygames.php');
    exit();
} else {
    $riddle_id = $_POST['riddle_id'];
    $user_id = $_SESSION['id'];
    $userResult = 0;

    $riddle = Riddle::findById($riddle_id);
    $move = Move::findByRiddleId($riddle->id);

    $opponent=Player::findById($move->player_id);

    $opponent_user_id = $opponent->user_id;
    $game_id = $move->game_id;

    $player = Player::findGamePlayerId($user_id, $game_id);
    $opponent_player = Player::findGamePlayerId($opponent_user_id, $game_id);

    $player_score=$player->score;
    $opponent_score=$opponent_player->score;

    if ($userResult == 1) {
        $player_score++;
        $opponent_score--;
    } else {
        $player_score--;
        $opponent_score++;
    }

    $player->score=$player_score;
    $opponent_player->score=$opponent_score;

    if (($opponent_player->save()) &&($player->save())) {
        echo "result saved";
    } else echo "problem with saving: " . $riddle->id;

}

