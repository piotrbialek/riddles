<?php
session_start();

include("../../projekt/notLoggedRedirect.php");
include("../admin/includes/Riddle.php");
include("../admin/includes/Move.php");
include("../admin/includes/Player.php");


if (!isset($_POST['userResult']) || !isset($_POST['riddleId'])) {
    header('Location: ../../projekt/games.php');
    exit();
} else {

    $user_id = $_SESSION['id'];
    $riddleId = $_POST['riddleId'];
    $userResult = $_POST['userResult'];

    $riddle = Riddle::findById($riddleId);
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

//    var_dump($player);
//    var_dump("<br>");
//    var_dump("<br>");
//    var_dump($opponent_player);

    if (($opponent_player->save()) &&($player->save())) {
        echo "result saved";
    } else echo "problem with saving: " . $riddle->id;

//    if ($riddle->riddleCompleted($userResult)) {
//        echo 1;
//    } else echo 0;

}




