<?php
session_start();

if ((isset($_POST['levelCompleted'])) && (($_POST['levelCompleted']) == true)) {
    $_SESSION["playerLevel"] = $_SESSION["playerLevel"] + 1;
} else {
    $_SESSION["playerLevel"] = 0;
    header("Location: ../../projekt/riddle.php");
}

$levelCompleted = $_POST['levelCompleted'];

require_once "../DBconnect.php";

if (isset($_SESSION['id'])) $id = $_SESSION['id'];
if (isset($_SESSION['login'])) $login = $_SESSION['login'];

if ((isset($_SESSION['id'])) && (isset($_SESSION['login']))) {

    $level = $_SESSION["playerLevel"];

    $con = @new mysqli($host, $db_user, $db_password, $db_name);

    if ($con->connect_errno != 0) {
        echo "Error: " . $con->connect_errno;
    } else {
        $query = "UPDATE users SET level='$level' WHERE login = '$login'";

        if ($level > 0) {
            if ($con->query($query) === TRUE) {
                echo "</br>You've got the level " . $level . "!";
            } else {
                echo "</br>Error updating record: " . $con->error;
            }
        }
        $con->close();
    }
}


