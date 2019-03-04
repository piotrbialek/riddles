<?php

session_start();

include("../../projekt/notLoggedRedirect.php");
include("../admin/includes/User.php");

$user = $_SESSION['id'];
$admin = $_SESSION['admin'];

if (!isset($_POST['setAdminId']) || !isset($_POST['setAdminAdmin'])) {
    header('Location: ../../projekt/singleplayer.php');
    exit();
} else {
    $setAdminId = $_POST['setAdminId'];
    $setAdminAdmin = $_POST['setAdminAdmin'];
}


if ($admin == 1) {
    if ($user != $setAdminId) {
        $setAdmin = new User();
        $setAdmin->id = $setAdminId;
        $setAdmin->admin = $setAdminAdmin;

        if ($setAdmin->setAdmin()) {
            echo $setAdmin->admin;
            exit;
        } else {
            echo 3;
            exit;
        }
    } else {
        echo "You can not change your own admin type";
    }
} else {
    echo "You do not have sufficient permissions";
}
