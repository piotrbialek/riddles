<?php

session_start();

include("../../projekt/notLoggedRedirect.php");
include("../admin/includes/Riddle.php");

$admin = $_SESSION['admin'];

if (!isset($_POST['riddle_id'])) {
    header('Location: ../../projekt/myGames.php');
    exit();
} else {
    $riddleId = $_POST['riddle_id'];
    $userId = $_SESSION['id'];
    $userResult = 0;

    $riddle = Riddle::findById($riddleId);
    $move = Move::findByRiddleId($riddle->id);

    $opponent = Player::findById($move->player_id);

    $opponent_user_id = $opponent->user_id;
    $gameId = $move->game_id;

    $player = Player::findGamePlayerId($userId, $gameId);
    $opponentPlayer = Player::findGamePlayerId($opponent_user_id, $gameId);

    $playerScore = $player->score;
    $opponentScore = $opponentPlayer->score;

    if ($userResult == 1) {
        $playerScore++;
        $opponentScore--;
    } else {
        $playerScore--;
        $opponentScore++;
    }

    $player->score = $playerScore;
    $opponentPlayer->score = $opponentScore;

    if (($opponentPlayer->save()) && ($player->save())) {
        echo "result saved";
    } else echo "problem with saving: " . $riddle->id;
}
