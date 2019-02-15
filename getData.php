<?php

session_start();
if (!isset($_SESSION['logged'])) {
    if (isset($_SESSION['player_level'])) {
        $playerLevel = $_SESSION['player_level'];
    }else{
        header('Location: index.php');
        exit();
    }
} else {
    $login = $_SESSION['login'];
    $playerLevelQuery = "SELECT level FROM users WHERE login='$login'";
}

require_once "DBconnect.php";

$con = @new mysqli($host, $db_user, $db_password, $db_name);

if ($con->connect_errno != 0) {
    echo "Error: " . $con->connect_errno;
} else {
    mysqli_query($con, "SET NAMES 'utf8'");

    if ($result = @$con->query("$playerLevelQuery")) {
        $row = $result->fetch_assoc();
        $currentLevel = $row['level'];
        $_SESSION['player_level'] = $currentLevel;

    } else {
        $currentLevel = $_SESSION['player_level'];
    }

    $query = "SELECT * FROM riddles WHERE accepted=1 and riddle_level='$currentLevel' ORDER BY RAND()";

    if ($result = @$con->query("$query"))
    {
        $num = $result->num_rows;
        if ($num > 0)
        {
            $row = $result->fetch_assoc();

            $category = $row['category'];
            $description = $row['description'];
            $riddle = $row['riddle'];

            $result->free_result();
        } else {
            $_SESSION['riddle_problem'] = '<span class="red">There was a problem with drawing riddles, sorry!</span>';
            header('Location: myRiddles.php');
        }
    }
    $con->close();
}
