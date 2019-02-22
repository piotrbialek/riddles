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

//require_once "../DBconnect.php";
//
//if (isset($_SESSION['id'])) $id = $_SESSION['id'];
//if (isset($_SESSION['login'])) $login = $_SESSION['login'];
//
//if ((isset($_SESSION['id'])) && (isset($_SESSION['login']))) {
//
//    $newLevel = $_SESSION["player_level"];
//
//    $con = @new mysqli($host, $db_user, $db_password, $db_name);
//
//    if ($con->connect_errno != 0) {
//        echo "Error: " . $con->connect_errno;
//    } else {
//        $query = "UPDATE users SET level='$newLevel' WHERE login = '$login'";
//
//        if ($newLevel > 0) {
//            if ($con->query($query) === TRUE) {
//                echo $messageSuccess;
//            } else {
//                echo "</br>Error updating record: " . $con->error;
//            }
//        }
//        $con->close();
//    }
//} else{
//    echo $messageSuccess;
//}


