<?php
header('Content-T: text/html; charset=UTF-8');

session_start();

include ("../projekt/notLoggedRedirect.php");

if (isset($_POST['riddle'])) {


    include "validate.php";


    require_once "DBconnect.php";
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

                if ($connection->query("INSERT INTO riddles VALUES (NULL, '$category', '$description', '$riddle','$riddleLevel','$id',0)")) {
                    if (isset($_SESSION['category'])) unset($_SESSION['category']);
                    if (isset($_SESSION['description'])) unset($_SESSION['description']);
                    if (isset($_SESSION['riddle'])) unset($_SESSION['riddle']);
                    if (isset($_SESSION['info_category'])) unset($_SESSION['info_category']);
                    if (isset($_SESSION['info_description'])) unset($_SESSION['info_description']);
                    if (isset($_SESSION['info_riddle'])) unset($_SESSION['info_riddle']);
                    if (isset($_SESSION['info_riddleLevel'])) unset($_SESSION['info_riddleLevel']);
                    if (isset($_SESSION['temp_category'])) unset($_SESSION['temp_category']);
                    if (isset($_SESSION['temp_description'])) unset($_SESSION['temp_description']);
                    if (isset($_SESSION['temp_riddle'])) unset($_SESSION['temp_riddle']);
                    if (isset($_SESSION['temp_riddleLevel'])) unset($_SESSION['temp_riddleLevel']);
                    $_SESSION['riddleAdded'] = 'Riddle has been added <span class="glyphicon glyphicon-check green"></span>';
                } else {
                    throw new Exception($connection->error);
                }

            }
            $connection->close();
        }
    } catch (Exception $ex) {
        echo '<span class="red">Something goes wrong..</span>';
        echo $ex;
    }
}