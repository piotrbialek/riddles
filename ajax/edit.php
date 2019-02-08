<?php

header('Content-T: text/html; charset=UTF-8');

session_start();

include ("../../projekt/notLoggedRedirect.php");

if (isset($_POST['riddleId'])) {

//    $category = $_POST['category'];
//    $description = $_POST['description'];
//    $riddle = $_POST['riddle'];
//    $riddleLevel = $_POST['riddleLevel'];
    $riddleId = $_POST['riddleId'];


    include "../../projekt/validate2.php";

    require_once "../../projekt/DBconnect.php";

    mysqli_report(MYSQLI_REPORT_STRICT);

    try {
        $connection = new mysqli($host, $db_user, $db_password, $db_name);
        if ($connection->connect_errno != 0) {
            throw new Exception(mysqli_connect_errno());
        } else {
            if ($validation) {
                $category = mb_strtoupper($category, 'UTF-8');
                $description = mb_strtoupper($description, 'UTF-8');
                $riddle = mb_strtoupper($riddle, 'UTF-8');

                mysqli_query($connection, "SET NAMES 'utf8'");

                $query = "UPDATE riddles 
SET category='$category' , 
description='$description' , 
riddle = '$riddle', 
riddleLevel = '$riddleLevel' 
WHERE id='$riddleId'";

                if ($connection->query($query)) {
                    if (isset($_SESSION['category'])) unset($_SESSION['category']);
                    if (isset($_SESSION['description'])) unset($_SESSION['description']);
                    if (isset($_SESSION['riddle'])) unset($_SESSION['riddle']);
                    if (isset($_SESSION['info_category_u'])) unset($_SESSION['info_category_u']);
                    if (isset($_SESSION['info_description_u'])) unset($_SESSION['info_description_u']);
                    if (isset($_SESSION['info_riddle_u'])) unset($_SESSION['info_riddle_u']);
                    if (isset($_SESSION['info_level_u'])) unset($_SESSION['info_level_u']);
                    if (isset($_SESSION['temp_category_u'])) unset($_SESSION['temp_category_u']);
                    if (isset($_SESSION['temp_description_u'])) unset($_SESSION['temp_description_u']);
                    if (isset($_SESSION['temp_riddle_u'])) unset($_SESSION['temp_riddle_u']);
                    if (isset($_SESSION['temp_level_u'])) unset($_SESSION['temp_level_u']);
                    echo 1;
                    exit;
                } else {
                    throw new Exception($connection->error);
                }

            } else {
                echo 0;
                exit;
            }
            $connection->close();
        }
    } catch (Exception $ex) {
        echo '<span class="red">Something goes wrong..</span>';
        echo $ex;
    }
}