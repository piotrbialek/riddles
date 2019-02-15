<?php

session_start();

include ("../../projekt/notLoggedRedirect.php");

require_once "../../projekt/DBconnect.php";

$con = @new mysqli($host, $db_user, $db_password, $db_name);


if ($con->connect_errno != 0) {
    echo "Error: " . $con->connect_errno;
} else {
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
    } else {
        header('Location: ../../projekt/game.php');
        exit();
    }


    if (isset($_POST['accepted'])) {
        $ifAccepted = $_POST['accepted'];
        if ($ifAccepted == 1) {
            $ifAccepted = 0;

        } else {
            $ifAccepted = 1;
        }
    }


    $user = $_SESSION['id'];
    $admin = $_SESSION['admin'];

    $con->set_charset("utf8");

    if ($admin == 1)
    {
        if ($sql = $con->prepare("UPDATE riddles SET accepted=$ifAccepted WHERE id=$id")) {
            $sql->execute();
            $sql->close();
            echo $ifAccepted;
            exit;
        } else {
            echo 3;
            throw new Exception($con->error);
        }
    } else echo "You do not have sufficient permissions.";

    $con->close();
    header('Location: riddles.php');
}
