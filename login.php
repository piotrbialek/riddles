<?php
include_once('../projekt/admin/includes/User.php');
session_start();
if ((!isset($_POST['login'])) || (!isset($_POST['pass']))) {
    header('Location: index.php');
    $_SESSION['login_error'] = 'Problem!';
    exit();
} else {
    $login = trim($_POST['login']);
    $pass = trim($_POST['pass']);


    $login = htmlentities($login, ENT_QUOTES, "UTF-8");
    $pass = htmlentities($pass, ENT_QUOTES, "UTF-8");

    $_SESSION['temp_login'] = $login;

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

        $user = User::verifyUser($login, $pass);

        echo "<br>";
        if ($user) {
            $_SESSION['logged'] = true;
            $_SESSION['id'] = $user->id;
            $_SESSION['login'] = $user->login;
            $_SESSION['pass'] = $user->pass;
            $_SESSION['email'] = $user->email;
            $_SESSION['player_level'] = $user->level;
            $_SESSION['admin'] = $user->admin;

            unset($_SESSION['login_error']);
            if (isset($_SESSION['temp_login'])) unset($_SESSION['temp_login']);
            if (isset($_SESSION['pass'])) unset($_SESSION['pass']);
            if (isset($_SESSION['email'])) unset($_SESSION['email']);
            header('Location: game.php');
        } else {
            $_SESSION['login_error'] = "Incorrect password or username";
            header('Location: index.php');
        }
        echo $the_message;
    } else {
        $_SESSION['login_error'] = 'Incorrect login or password!';
    }

}
