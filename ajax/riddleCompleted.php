<?php
session_start();

include("../../projekt/notLoggedRedirect.php");
include("../admin/includes/Riddle.php");


if (!isset($_POST['userResult']) || !isset($_POST['riddleId'])) {
    header('Location: ../../projekt/singleplayer.php');
    exit();
} else {
    $riddleId = $_POST['riddleId'];
    $userResult = $_POST['userResult'];

    $riddle = Riddle::findById($riddleId);

    if ($riddle->riddleCompleted($userResult)) {
        echo 1;
    } else echo 0;
}




