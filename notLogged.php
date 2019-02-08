<?php
if (!isset($_SESSION['logged']))
    {
        if (!isset($_SESSION['playerLevel']))
        {
            $_SESSION['playerLevel']=0;
    		header('Location: riddle.php');
    		exit();
        }
    }
