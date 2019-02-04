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
    if (isset($_GET['setAdmin'])) {
        $id = $_GET['setAdmin'];
    }

    if (isset($_GET['admin'])) {
        $ifAdmin = $_GET['admin'];
        if ($ifAdmin == 1) {
            $ifAdmin = 0;
        } else {
            $ifAdmin = 1;
        }
    }

    $user = $_SESSION['id'];
    $admin = $_SESSION['admin'];

    //include "polacz.php";
    $con->set_charset("utf8");

    if ($admin == 1 && $user != $id) {
        echo "Administrator manages all the riddles";
        echo "
						<table class='table' id='table'>
						<tr>
						<th>Id</th><th>Category</th><th>Description</th><th>Riddle</th><th>Level</th><th>Autor ID</th><th>Edit</th><th>Delete</th>
						</tr>";
        if ($sql = $con->prepare("UPDATE users SET admin=$ifAdmin WHERE id=$id")) {
            $sql->execute();
            echo "DONE: " . $id;
            $sql->close();
            $_SESSION['admin_info'] = "You have changed user's (id=$id) user type.";
            $_SESSION['admin_info'] = "<div class='alert alert-success alert-dismissable'>You have changed user's (id=$id) user type.</div>";
        } else {
            throw new Exception($con->error);
        }
    } else {
        echo "You do not have sufficient permissions";
        if ($user == $id) $_SESSION['admin_info'] = "<div class='alert alert-danger alert-dismissable'>You can not change your own user type.</div>";
    }

    $con->close();
    header('Location: allUsers.php');
}
?>