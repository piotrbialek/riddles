<?php

session_start();

if (!isset($_SESSION['logged'])) {
    header('Location: index.php');
    exit();
}

if (isset($_SESSION['admin'])) {
    if ($_SESSION['admin'] == 0) {
        header('Location: userMenu.php');
    }
}

require_once "../../projekt/DBconnect.php";

$con = @new mysqli($host, $db_user, $db_password, $db_name);


if ($con->connect_errno != 0) {
    echo "Error: " . $con->connect_errno;
} else {
    if (isset($_GET['delete'])) {
        $id = $_GET['delete'];
    }

    $user = $_SESSION['id'];
    $admin = $_SESSION['admin'];

    $con->set_charset("utf8");

    if ($admin == 1) {
        echo "Administrator manages all the riddles";
        echo "
    <table class='table' id='table'>
	<tr>
	<th>Id</th><th>Category</th><th>Description</th><th>Riddle</th><th>Level</th><th>Autor ID</th><th>Edit</th><th>Delete</th>
	</tr>";
        if ($sql = $con->prepare("DELETE FROM riddles WHERE id=$id")) {
            $sql->execute();
            echo "DONE: " . $id;
            $sql->close();
        } else {
            throw new Exception($con->error);
        }
    } else {
        echo "You do not have sufficient permissions";
    }

    $con->close();
    header('Location: allRiddles.php');
}
