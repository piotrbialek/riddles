<?php
session_start();
include("../admin/includes/User.php");
//include ("../../projekt/notLoggedRedirect.php");


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
    $user = new User();
    $user->id = $id;
    $user->level = $currentLevel;

    if($user->increaseLevel()) echo $messageSuccess;
    else echo $messageProblem;
} else $messageSuccess;



