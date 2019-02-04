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
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        echo 'ID: ' . $id;
    }

    if (isset($_GET['lvlUp'])) {
        $lvl = $_GET['lvl'];
        $changed = $lvl;
        //echo $lvlUp.'=przed ';
        if ($lvl < 20) {
            $changed++;
        } else if ($lvl == 20) {
            $_SESSION['lvl_info'] = "<div class='alert alert-danger'>Maximum level is 20, you can not increase it.</div>";
        }
        echo 'po: ' . $changed;


    }
    if (isset($_GET['lvlDown'])) {
        $lvl = $_GET['lvl'];
        $changed = $lvl;
        //echo $lvlDown.'=przed ';
        if ($lvl > 0) {
            $changed--;
        } else if ($lvl == 0) {
            $_SESSION['lvl_info'] = "<div class='alert alert-danger'>Minimum level is 0, you can not decrease it.</div>";
        }
        echo 'po: ' . $changed;
        //echo $lvlDown.'=po ';

    }

    echo $changed . '=changed ';

    $user = $_SESSION['id'];
    $admin = $_SESSION['admin'];

    $con->set_charset("utf8");

    if ($admin == 1 && ($lvl >= 0 && $lvl <= 20)) {
//						echo "Administrator manages all the riddles";
//						echo "
//						<table class='table' id='table'>
//						<tr>
//						<th>Id</th><th>Category</th><th>Description</th><th>Riddle</th><th>Level</th><th>Autor ID</th><th>Edit</th><th>Delete</th>
//						</tr>";

        if ($lvl === $changed) {
            $_SESSION['lvl_info'] = "<div class='alert alert-danger'>Level must be between 0 and 20.</div>";
        } elseif (isset($_GET['id'])) {
            if ($sql = $con->prepare("UPDATE riddles SET riddleLevel=$changed WHERE id=$id")) {
                $sql->execute();
                echo "DONE: " . $id;
                $sql->close();
                $_SESSION['lvl_info'] = "<div class='alert alert-success'>You have changed riddle (id=$id) level to $changed.</div>";
            } else {
                throw new Exception($con->error);
            }

        }
    } else {
        echo "You do not have sufficient permissions";
    }

    $con->close();
    header('Location: allRiddles.php');
}
?>