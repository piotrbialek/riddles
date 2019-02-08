<?php
if (!isset($_SESSION['logged'])) {
    header('Location: ../../projekt/index.php');
    exit();
}