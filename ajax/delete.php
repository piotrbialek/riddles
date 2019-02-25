<?php

session_start();

include ("../../projekt/notLoggedRedirect.php");
include("../admin/includes/Riddle.php");


if (isset($_POST['id'])) {
    $id = $_POST['id'];
} else {
    header('Location: ../../projekt/game.php');
    exit();
}

$deleteRiddle = new Riddle();
$deleteRiddle->id=$id;

if ($deleteRiddle->delete()) {
    echo 1;
} else echo 0;
exit;