<?php

session_start();

include ("../../projekt/notLoggedRedirect.php");


require_once "../../projekt/DBconnect.php";


if (isset($_POST['id'])) {
    $id = $_POST['id'];
} else {
    header('Location: ../../projekt/riddle.php');
    exit();
}

if (isset($_POST['columnName'])) {
    $columnName = $_POST['columnName'];
} else {
    header('Location: ../../projekt/riddle.php');
    exit();
}


if ($id >= 0) {

    $con = @new mysqli($host, $db_user, $db_password, $db_name);
    $checkRecord = mysqli_query($con, "SELECT * FROM " . $columnName . " WHERE id=" . $id);
    $totalRows = mysqli_num_rows($checkRecord);

    if ($totalRows > 0) {
        $query = "DELETE FROM " . $columnName . " WHERE id=" . $id;
        mysqli_query($con, $query);
        echo 1;
        exit;
    }
} else {
    echo "Invalid ID";
}
exit;