<?php

session_start();

include ("../../projekt/notLoggedRedirect.php");

require_once "../../projekt/DBconnect.php";

$con = @new mysqli($host, $db_user, $db_password, $db_name);


if ($con->connect_errno != 0) {
    echo "Error: " . $con->connect_errno;
} else {
    if (isset($_POST['setAdminId'])) {
        $id = $_POST['setAdminId'];
    }

    if (isset($_POST['admin'])) {
        $ifAdmin = $_POST['admin'];
        if ($ifAdmin == 1) {
            $ifAdmin = 0;
        } else {
            $ifAdmin = 1;
        }
    }

    $user = $_SESSION['id'];
    $admin = $_SESSION['admin'];

    $con->set_charset("utf8");

    if ($admin == 1) {

        if ($user != $id) {
            if ($sql = $con->prepare("UPDATE users SET admin=$ifAdmin WHERE id=$id")) {
                $sql->execute();
                $sql->close();
                echo $ifAdmin;
                exit;
            } else {
                throw new Exception($con->error);
                echo 3;
                exit;
            }
        } else {
            echo "You can not change your own admin type";
        }
    } else {
        echo "You do not have sufficient permissions";
    }

    $con->close();
}
