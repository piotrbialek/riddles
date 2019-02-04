<?php
		session_start();
		
		if (!isset($_SESSION['logged']))
		{
//			header('Location: index.php');
//			exit();
            
		}
        
        //----------------------$_SESSION["playerLevel"]=$_SESSION["playerLevel"]+1;
		

        if ((isset($_SESSION['levelCompleted']))&&(($_SESSION['levelCompleted'])==true))
		{
            $_SESSION["playerLevel"]=$_SESSION["playerLevel"]+1; 
		}
else $_SESSION["playerLevel"]=0;
            
        $levelCompleted = $_SESSION['levelCompleted'];
        echo "\nlevel completed1:".$levelCompleted;


        // --------------------------------------------------------------dziala
//        $levelCompleted = $_COOKIE['levelCompleted'];
//        echo "1:".$levelCompleted;

		
		require_once "DBconnect.php";
		
		$id=$_SESSION["id"];
		$level=$_SESSION["playerLevel"];
		$login = $_SESSION['login'];
		$currentLevel="SELECT poziom FROM users WHERE login='$login'";		
		

		$con = @new mysqli($host, $db_user, $db_password, $db_name);
				
		if ($con->connect_errno!=0)
		{
			echo "Error: ".$con->connect_errno;
		}
		else
		{
				$query = "UPDATE users SET level='$level' WHERE login = '$login'";
	
				if($level>0)
				{
					if ($con->query($query) === TRUE) {
//                        echo $_SESSION["levelCompleted"];
					echo "</br>Record updated successfully, level =".$level;
                        
					} else {
					echo "</br>Error updating record: " . $con->error;
					}
				}		

			if ($rezultat = @$con->query("$currentLevel"))
			{
				$wiersz = $rezultat->fetch_assoc();
				echo "</br>-->".$wiersz['poziom']."<- poziom gracza</br>";
				echo gettype($wiersz['poziom'])."<- typ";
			}
			$con->close();
		}
		
header('Location: riddle.php');

?>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script> 
    <script src="js/skryptRiddle.js"></script>
    <script src="js/typed.js" type="text/javascript"></script>
	<title>Riddles</title>

</head>  
<body>
    </body></html>