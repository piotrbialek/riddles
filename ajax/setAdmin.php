<?php
session_start();

include("../../projekt/notLoggedRedirect.php");
include("../admin/includes/User.php");

$user = $_SESSION['id'];
$ifIamAdmin = $_SESSION['admin'];

if (!isset($_POST['adminId']) || !isset($_POST['admin'])) {
    header('Location: ../../projekt/singleplayer.php');
    exit();
} else {
    $adminId = $_POST['adminId'];
    $admin = $_POST['admin'];
}

if ($ifIamAdmin == 1) {
    if ($user != $adminId) {
        $setAdmin = User::findById($adminId);
        $setAdmin->admin = 1 - $admin;

        if ($setAdmin->save()) {
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
