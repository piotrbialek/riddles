<?php

	session_start();
	
	if ((isset($_SESSION['logged'])) && ($_SESSION['logged']==true))
	{
		header('Location: myRiddles.php');
		exit();
	}
    else 
    {
        $_SESSION['playerLevel']=0;
    }

?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Riddles - Log in!</title>
	<link rel="stylesheet" href="style.css" type="text/css" />
	<link rel="stylesheet" href="css/bootstrap.css" type="text/css">
</head>

<body>
	<div class="container text-center">
		<div id="title">Riddles</div>
		<div id="header" class="text-center">
		Log in!
		</div>
	
	<form class="sendForm" action="login.php" method="post">
		<br>
			<span><i class="glyphicon glyphicon-user"></i></span>
			<input required class="input" type="text" name="login" placeholder="Login" onfocus="this.placeholder=''" onblur="this.placeholder='Login'"
				value="<?php
			if (isset($_SESSION['temp_login']))
			{
				echo $_SESSION['temp_login'];
				unset($_SESSION['temp_login']);
			}
		?>" autofocus/>

		<br>
		<br>

        <span><i class="glyphicon glyphicon-lock"></i></span>
		<input required class="input" type="password" name="pass"placeholder="Password" onfocus="this.placeholder=''" onblur="this.placeholder='Password'" />

		<br><br>
		<span class="red">
		<?php
			if(isset($_SESSION['loginError']))	echo $_SESSION['loginError'];
			unset($_SESSION['loginError']);
		?>
		</span>
		<br><br>
		<a href="registration.php">Don't have an account? Sign up!</a>
		<br>
		<button type="submit" class="btn btn-primary button">Log in <span class="glyphicon glyphicon-log-in"></span></button>
        <br>
        <br>
        <a href="notLogged.php">Continue without account</a>
	
	</form>
	
	</div>
</body>
</html>