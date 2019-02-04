<?php
	session_start();
	
	if (!isset($_SESSION['registrationOK']))
	{
		header('Location: index.php');
		exit();
	}
	else
	{
		unset($_SESSION['registrationOK']);
	}
	if (isset($_SESSION['temp_login'])) unset($_SESSION['temp_nick']);
	if (isset($_SESSION['temp_email'])) unset($_SESSION['temp_email']);
	if (isset($_SESSION['temp_pass1'])) unset($_SESSION['temp_pass1']);
	if (isset($_SESSION['temp_pass2'])) unset($_SESSION['temp_pass2']);
	if (isset($_SESSION['info_login'])) unset($_SESSION['info_login']);
	if (isset($_SESSION['info_email'])) unset($_SESSION['info_email']);
	if (isset($_SESSION['info_pass'])) unset($_SESSION['info_pass']);
?>

<!DOCTYPE HTML>
<html lang="pl">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<title>Riddles - Succesful registration</title>
		<link rel="stylesheet" href="css/main.css" type="text/css" />
		<link rel="stylesheet" href="css/bootstrap.css" type="text/css">
	</head>

	<body>
		<div class="container text-center">
			<header class="title text-center">Riddles</header>
			<div class="formHeader">Succesful registration</div>
			
			<div class="sendForm">
				</br>
				Thank you for registering!
				</br>		
				Your account was created successfully, 
				</br>	
				now you can <a href="index.php">log in</a>.
				</br>
				</br>	
			</div>
		</div>
	</body>
</html>
