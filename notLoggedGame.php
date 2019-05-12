<?php
if (!isset($_SESSION['logged'])) {
    if (!isset($_SESSION['player_level'])) {
        $_SESSION['player_level'] = 1;
        header('Location: singleplayer.php');
        exit();
    }
}
