<?php

session_start();

if ((!isset($_POST['login'])) || (!isset($_POST['pass']))) {
    header('Location: index.php');
    $_SESSION['login_error'] = 'Problem!';
    exit();
}

require_once "DBconnect.php";

$connection = @new mysqli($host, $db_user, $db_password, $db_name);
$_SESSION['temp_login'] = $login;

if ($connection->connect_errno != 0) {
    echo "Error: " . $connection->connect_errno;
} else {
    $login = trim($_POST['login']);
    $pass = trim($_POST['pass']);


    $login = htmlentities($login, ENT_QUOTES, "UTF-8");
    $pass = htmlentities($pass, ENT_QUOTES, "UTF-8");

    // sql injection validation
    $validation = true;

    if (ctype_alnum($login) == false) {
        $validation = false;
        header('Location: index.php');

    }
    if (ctype_alnum($pass) == false) {
        $validation = false;
        header('Location: index.php');
    }


    if ($validation == true) {
        if ($result = @$connection->query(
            sprintf("SELECT * FROM users WHERE login='%s' LIMIT 1",
                mysqli_real_escape_string($connection, $login)))) {
            $count_users = $result->num_rows;
            if ($count_users > 0) {
                $row = $result->fetch_assoc();

                if (password_verify($pass, $row['pass'])) {
                    $_SESSION['logged'] = true;
                    $_SESSION['id'] = $row['id'];
                    $_SESSION['login'] = $row['login'];
                    $_SESSION['pass'] = $row['pass'];
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['player_level'] = $row['level'];
                    $_SESSION['admin'] = $row['admin'];


                    unset($_SESSION['login_error']);
                    $result->free_result();
                    if (isset($_SESSION['temp_login'])) unset($_SESSION['temp_login']);
                    if (isset($_SESSION['pass'])) unset($_SESSION['pass']);
                    if (isset($_SESSION['email'])) unset($_SESSION['email']);
                    header('Location: game.php');
                } else {
                    $_SESSION['login_error'] = 'Incorrect login or password!';

                    header('Location: index.php');
                }

            } else {

                $_SESSION['login_error'] = 'Incorrect login or password!';

                header('Location: index.php');

            }

        }
    } else {
        $_SESSION['login_error'] = 'Incorrect login or password!';
    }
    $connection->close();
}

?>