<?php

session_start();

include("../../projekt/notLoggedRedirect.php");
include("../admin/includes/Riddle.php");


if (isset($_POST['id'])) {
    $id = $_POST['id'];
} else {
    header('Location: ../../projekt/singleplayer.php');
    exit();
}

$deleteRiddle = new Riddle();
$deleteRiddle->id = $id;
$riddle=Riddle::findById($deleteRiddle->id);

if ($riddle->in_match==0) {
    if ($deleteRiddle->delete()) {
        echo 1;
    } else echo "There was a problem with deleting riddle.";
}else echo "You can't delete riddle that takes or took part in the game.";
exit;