<?php
if (!isset($_SESSION['logged'])) {
    if (!isset($_SESSION['player_level'])) {
        $_SESSION['player_level'] = 0;
        header('Location: game.php');
        exit();
    }
}
