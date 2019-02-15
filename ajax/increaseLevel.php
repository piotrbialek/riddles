<?php
session_start();

//include ("../../projekt/notLoggedRedirect.php");

if ((isset($_POST['levelCompleted'])) && (($_POST['levelCompleted']) == true)) {
    $_SESSION["player_level"] = $_SESSION["player_level"] + 1;
} else {
    $_SESSION["player_level"] = 0;
}

$newLevel = $_SESSION["player_level"];
$messageSuccess="</br>You've got the level " . $newLevel . "!";


require_once "../DBconnect.php";

if (isset($_SESSION['id'])) $id = $_SESSION['id'];
if (isset($_SESSION['login'])) $login = $_SESSION['login'];

if ((isset($_SESSION['id'])) && (isset($_SESSION['login']))) {

    $newLevel = $_SESSION["player_level"];

    $con = @new mysqli($host, $db_user, $db_password, $db_name);

    if ($con->connect_errno != 0) {
        echo "Error: " . $con->connect_errno;
    } else {
        $query = "UPDATE users SET level='$newLevel' WHERE login = '$login'";

        if ($newLevel > 0) {
            if ($con->query($query) === TRUE) {
                echo $messageSuccess;
            } else {
                echo "</br>Error updating record: " . $con->error;
            }
        }
        $con->close();
    }
} else{
    echo $messageSuccess;
}


