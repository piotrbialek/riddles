<?php
session_start();

include("../../projekt/notLoggedRedirect.php");
include("../admin/includes/Riddle.php");

$admin = $_SESSION['admin'];

if (!isset($_POST['id']) || !isset($_POST['accepted'])) {
    header('Location: ../../projekt/singleplayer.php');
    exit();
} else {
    $id = $_POST['id'];
    $accepted = $_POST['accepted'];
}
if ($admin == 1) {
    $acceptRiddle = new Riddle();
    $acceptRiddle->id = $id;
    $acceptRiddle->accepted = $accepted;

    if ($acceptRiddle->acceptRiddle()) {
        echo $acceptRiddle->accepted;
    } else echo 3;
}
