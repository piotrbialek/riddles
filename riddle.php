<?php

	session_start();

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
            if (!isset($_SESSION['playerLevel'])) header('Location: index.php');
            

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
<script type="text/javascript">
  var category = '<?php echo $category ;?>';
  var description = <?php echo json_encode($description); ?>;
  var riddle = <?php echo json_encode($riddle); ?>;
  var level = <?php echo json_encode($current_level); ?>;  
    

</script>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script> 
    <script src="skryptRiddle.js"></script>
    <script src="typed.js" type="text/javascript"></script>
	<title>Riddles</title>
	<link rel="stylesheet" href="style.css" type="text/css" />
    <link rel="stylesheet" href="css/bootstrap.css" type="text/css">
</head>

    
<body>
    

	<div class="container">
        
        
			<?php include ('title.php') ?>
        
        
						<?php
					if (isset($_SESSION['blad']))
					{
						echo $_SESSION['blad'];
						//unset($_SESSION['blad']);
					}?>
		
            
            <div class="row">
			<?php
					if (isset($_SESSION['info_level']))
					{
						echo $_SESSION['info_level'];
						unset($_SESSION['info_level']);
					}?>
				<div class="category text-center" id="category"></div>
            </div>
            
            <div class="row text-center">    
                <div id="description"></div>
            </div>
			
            
            <div class="row">
				<div id="organize">
                    <div class="col-xs-4">

							<input class="pull-right" id="input" autofocus/>
						
                    </div>
                    <div class="col-xs-8 guesses">
                        <span class="glyphicon glyphicon-ok green" style="font-size:120%"></span>
                        <span class="green" id="rightGuesses"></span><br>
                        <span class="glyphicon glyphicon-remove red" style="font-size:120%"></span>
                        <span class="red" id="wrongGuesses"></span>
                    </div>
			
				</div>
            </div>
			<div class="text-center" id="info"> </div>
            <div class="text-center">
                <button class="btn btn-primary button" id="buttonNext">NEXT RIDDLE</button>
			    <button class="btn btn-primary button" id="buttonTryAgain">TRY AGAIN</button>
            </div>
            
            <div class="row">
                <div class="col-lg-1 col-md-1"></div>
<!--                <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 text-center" id="sentence"></div>-->
                <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12" id="sentence"></div>
                <div class="col-lg-5 col-md-5" id="image">
                    <img id="imageImg" src="image/transparent/wisielec0.png" class="img-responsive">
                </div>
                <div class="col-lg-1 col-md-1"></div>
			</div>	
	</div>

 

</body>
</html>