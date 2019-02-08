<?php

session_start();

include ("../projekt/notLoggedRedirect.php");

//$levelCompleted=$_SESSION['levelCompleted'];

//    $levelCompleted=$_SESSION['levelCompleted'];
	
//    if (isset($_SESSION['playerLevel']))
//    {
        if (!isset($_SESSION['logged']))
        {
    //		header('Location: index.php');
    //		exit();
            //$_SESSION['playerLevel']=0;
            
            
            
            $playerLvl=$_SESSION['playerLevel'];
            if (!isset($_SESSION['playerLevel'])) 
            {
                header('Location: index.php');
                exit();// ---------------------------------------------dodane, nie bylo
            }
            

        }


        else
        {

            $login = $_SESSION['login'];
            $playerLvl="SELECT level FROM users WHERE login='$login'"; //zapytanie do bazy - pobranie poziomu gracza

        }
   //}
//    else
//    {
////        $_SESSION['playerLevel']=0;
////        echo '<script>console.log("!playerLevel")</script>';
//        header('Location: index.php');
//    }

    require_once "DBconnect.php";
    


	
	$con = @new mysqli($host, $db_user, $db_password, $db_name);
	
	if ($con->connect_errno!=0)
	{
		echo "Error: ".$con->connect_errno;
	}
	else
	{
		mysqli_query($con,"SET NAMES 'utf8'");
				
		if ($result = @$con->query("$playerLvl"))
		{
            $row = $result->fetch_assoc();        
            //echo "if";    
            
            $current_level=$row['level']; //$current_level=$row['poziom']; <-- before

			$_SESSION['playerLevel']=$current_level;
		}
        else
        {
//            $row = $result->fetch_assoc();       
            $current_level=$_SESSION['playerLevel'];
            //echo "else";

        }
       

		
		$query="SELECT * FROM riddles WHERE accepted=1 and riddleLevel='$current_level' ORDER BY RAND()";

	
		if ($result = @$con->query("$query")) //wylosowanie zagadki zaakceptowanej i zgodnej z obecnym poziomem ( randomowo )
		{

			$num = $result->num_rows;
			if($num>0) //pobranie danych z wylosowanego wiersza
			{
					$row = $result->fetch_assoc();
				
					$_SESSION['id_riddle'] = $row['id'];
					$id=$_SESSION['id_riddle'];
					
					$_SESSION['category'] = $row['category'];
					$category=$_SESSION['category'];
					
					$_SESSION['description'] = $row['description'];
					$description=$_SESSION['description']; 
					
					$_SESSION['riddle'] = $row['riddle'];
					$riddle=$_SESSION['riddle'];

					$result->free_result();
				
			}
			else // jesli nie uda sie wylosowac to znaczy ze nie ma w bazie
			{

				$_SESSION['blad'] = '<span class="red">You have reached the maximum ('.$current_level.') level. Update soon!</span>';
				$message = "You have reached the maximum ('.$current_level.') level. Update soon!";
				echo "<script type='text/javascript'>alert('$message');</script>";
				header('Location: myRiddles.php');
				
			}
			
		}

		
		$con->close();
	
	}

?>