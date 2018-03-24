<?php

	session_start();
	
	if (!isset($_SESSION['logged']))
	{
		header('Location: index.php');
		exit();
	}
	
	require_once "DBconnect.php";

?>

<!DOCTYPE HTML>
<html lang="pl">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<title>Riddles - my Riddles</title>
		<link rel="stylesheet" href="style.css" type="text/css" />
		<link rel="stylesheet" href="css/bootstrap.css" type="text/css">
	</head>

	<body>
		<div class="container" id="container">

        <?php include ('title.php') ?>
        <?php
					if (isset($_SESSION['blad']))
					{
						echo $_SESSION['blad'];
						unset($_SESSION['blad']);
					}
        ?>


			<div>
<!--                <div class="text-center">My riddles</div>-->


				<?php
				$polaczenie4 = @new mysqli($host, $db_user, $db_password, $db_name);
		
		
				if ($polaczenie4->connect_errno!=0)
				{
					echo "Error: ".$polaczenie4->connect_errno;
				}
				else
				{
		
					$user=$_SESSION['id'];
					$admin=$_SESSION['admin'];

					//include "polacz.php";
					$polaczenie4 ->set_charset("utf8");
					if($admin==0 || $admin==1)
					{
						
						echo "
						<table class='table table-bordered table-condensed' id='table'>
						<tr>
						<th>Category</th><th>Description</th><th>Riddle</th><th>Level</th>
						</tr>";
							if ($sql = $polaczenie4->prepare("SELECT id, category, description, riddle, riddleLevel, (SELECT count(ri.author_id) from `riddles` ri join `users` us on ri.author_id = us.id where us.id=$user GROUP by ri.author_id), (SELECT count(ri.author_id) from `riddles` ri join `users` us on ri.author_id = us.id where us.id=$user and ri.accepted=1) FROM `riddles` WHERE author_id=$user"))
								{        
									$sql->execute();
									$sql->bind_result($id, $category, $description, $riddle, $riddleLevel, $myRiddles, $myRiddlesA);

									while ($sql->fetch())
									{
										echo <<< EOT
										
											<tr>
											<td>$category</td>
											<td>$description</td>
											<td>$riddle</td>  													
											<td class="text-center">$riddleLevel</td>  													
											</tr>
EOT;
									}
									$sql->close();
								}
								else
								{
									throw new Exception($polaczenie4->error);
								}
                        echo "<div class='text-center'>My riddles($myRiddlesA / $myRiddles)</div></table>";
					}

					 $polaczenie4->close();
				}
?>
			
			</div>
            <?php include ('buttons.php') ?>
        
		</div>

	</body>
</html>