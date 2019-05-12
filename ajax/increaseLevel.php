<?php
session_start();
include("../admin/includes/User.php");

$currentLevel = $_SESSION["player_level"];
if ((isset($_POST['levelCompleted'])) && (($_POST['levelCompleted']) == true)) {
    $_SESSION["player_level"] = $_SESSION["player_level"] + 1;
} else {
    header('Location: ../../projekt/index.php');
}

$newLevel = $_SESSION["player_level"];
$messageSuccess = "</br>You've got the level " . $newLevel . "!";
$messageProblem = "</br>Some problem occurred.";

if (isset($_SESSION['id'])) {
    $id = $_SESSION["id"];
    $user = User::findById($id);
    $user->level = $newLevel;

    if ($user->save()) echo $messageSuccess;
    else echo $messageProblem;
} else echo $messageSuccess;