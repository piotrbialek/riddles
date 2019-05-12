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

    $userId = $_SESSION['id'];
    $riddleId = $_POST['riddleId'];
    $userResult = $_POST['userResult'];

    $riddle = Riddle::findById($riddleId);
    $move = Move::findByRiddleId($riddle->id);

    $opponent=Player::findById($move->player_id);

    $opponentUserId = $opponent->user_id;
    $gameId = $move->game_id;

    $player = Player::findGamePlayerId($userId, $gameId);
    $opponentPlayer = Player::findGamePlayerId($opponentUserId, $gameId);

    $playerScore=$player->score;
    $opponentScore=$opponentPlayer->score;

    if ($userResult == 1) {
        $playerScore++;
        $opponentScore--;
    } else {
        $playerScore--;
        $opponentScore++;
    }

    $player->score=$playerScore;
    $opponentPlayer->score=$opponentScore;

    if (($opponentPlayer->save()) &&($player->save())) {
        echo "result saved";
    } else echo "problem with saving: " . $riddle->id;

//    if ($riddle->riddleCompleted($userResult)) {
//        echo 1;
//    } else echo 0;

}




