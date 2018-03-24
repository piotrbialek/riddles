<?php
		session_start();
		
		if (!isset($_SESSION['logged']))
		{
//			header('Location: index.php');
//			exit();
            
		}
        
		$_SESSION["playerLevel"]=$_SESSION["playerLevel"]+1;
		
		
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
					echo "</br>Record updated successfully, level =".$level;//."---pNowy=".$poziomNowy."---";
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
