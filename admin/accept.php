<?php

session_start();

if (!isset($_SESSION['logged'])) {
    header('Location: index.php');
    exit();
}

require_once "../../projekt/DBconnect.php";

$con = @new mysqli($host, $db_user, $db_password, $db_name);


if ($con->connect_errno != 0) {
    echo "Error: " . $con->connect_errno;
} else {
    if (isset($_GET['accept'])) {
        $id = $_GET['accept'];
    }

    if (isset($_GET['accepted'])) {
        $ifAccepted = $_GET['accepted'];
    }

    if (isset($_GET['accepted'])) {
        $ifAccepted = $_GET['accepted'];
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
            if ($ifAccepted == 0) $info = "NOT";
            else $info = "accepted";
            $_SESSION['accept_info'] = "<div class='alert alert-success'>You have changed riddle (id=$id): Accepted=$info</div>";
        } else {
            throw new Exception($con->error);
        }
    } else echo "You do not have sufficient permissions.";

    $con->close();
    header('Location: allRiddles.php');
}
