<?php

	session_start();
	
	
	if ((isset($_SESSION['logged'])) && ($_SESSION['logged']==true))
	{
		header('Location: riddle.php');
		exit();
	}

	
	if (isset($_POST['email']))
	{

		$validation=true;
		
		$login = $_POST['login'];

		if ((strlen($login)<3) || (strlen($login)>20))
		{
			$validation=false;
			$_SESSION['info_login']="Login must be between 3 and 60 characters!";
		}
		
		if (ctype_alnum($login)==false)
		{
			$validation=false;
			$_SESSION['info_login']="Login can only consist of alphanumeric characters!";
		}
		
		$email = $_POST['email'];
		$emailB = filter_var($email, FILTER_SANITIZE_EMAIL);
		
		if ((filter_var($emailB, FILTER_VALIDATE_EMAIL)==false) || ($emailB!=$email))
		{
			$validation=false;
			$_SESSION['info_email']="Email address is not valid!";
		}
		
		$pass1 = $_POST['pass1'];
		$pass2 = $_POST['pass2'];
		
		if (preg_match('/[\'^$%&*()}{@#~?><>,|=_+.;:-]/', $pass1))
		{
			$validation=false;
			$_SESSION['info_pass']="Password contains invalid characters!";
		}
		
		
		if ((strlen($pass1)<8) || (strlen($pass1)>20))
		{
			$validation=false;
			$_SESSION['info_pass']="Password must be between 8 and 20 characters!";
		}
		
		if ($pass1!=$pass2)
		{
			$validation=false;
			$_SESSION['info_pass']="The passwords are not identical!";
		}	

		$pass_hash = password_hash($pass1, PASSWORD_DEFAULT);
		

		$_SESSION['temp_login'] = $login;
		$_SESSION['temp_email'] = $email;
		$_SESSION['temp_pass1'] = $pass1;
		$_SESSION['temp_pass2'] = $pass2;
		
		
		require_once "DBconnect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);
		
		try 
		{
			$connection = new mysqli($host, $db_user, $db_password, $db_name);
			if ($connection->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}
			else
			{
				$result = $connection->query("SELECT id FROM users WHERE email='$email'");
				
				if (!$result) throw new Exception($connection->error);
				
				$count_mail = $result->num_rows;
				if($count_mail>0)
				{
					$validation=false;
					$_SESSION['info_email']="There is already an account assigned to this email address!";
				}		

				
				$result = $connection->query("SELECT id FROM users WHERE login='$login'");
				
				if (!$result) throw new Exception($connection->error);
				
				$count_login = $result->num_rows;
				if($count_login>0)
				{
					$validation=false;
					$_SESSION['info_login']="This login already exists! Choose another one.";
				}
				
				if ($validation==true)
				{
					
					if ($connection->query("INSERT INTO users VALUES (NULL, '$login', '$pass_hash', '$email',0,0)"))
					{
						$_SESSION['registrationOK']=true;
						header('Location: success.php');
					}
					else
					{
						throw new Exception($connection->error);
					}
					
				}
				
				$connection->close();
			}
			
		}
		catch(Exception $e)
		{
			$_SESSION['info_server']="Server problem, we are very sorry! Development information: '.$e;";
		}
		
	}
	
	
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Riddles - registration</title>
	<link rel="stylesheet" href="style.css" type="text/css" />
	<link rel="stylesheet" href="css/bootstrap.css" type="text/css">
	

</head>

<body>
		<div class="container text-center">
			<span class="red">
				<?php
					if (isset($_SESSION['info_server']))
					{
						echo $_SESSION['info_server'];
						unset($_SESSION['info_server']);
					}
				?>
			</span>
			<div id="title">Riddles</div>
			<div id="header">Registration</div>

					<form class="sendForm" method="post"> 
<!--                        nie ma action to plik POSTem wysle do samego siebie?-->
					
						<br> 
						<span><i class="glyphicon glyphicon-user"></i></span>
						<input required class="input" type="text" name="login" placeholder="Login" onfocus="this.placeholder=''" onblur="this.placeholder='Login'" 
						value="<?php
							if (isset($_SESSION['temp_login']))
							{
								echo $_SESSION['temp_login'];
								unset($_SESSION['temp_login']);
							}
						?>"/>
						<br>
						<span class="red">
							<?php
							if (isset($_SESSION['info_login']))
							{
								echo $_SESSION['info_login'];
								unset($_SESSION['info_login']);
							}
							?>
						</span>
						<br> 
						
						<span><i class="glyphicon glyphicon-envelope"></i></span>
						<input required class="input" type="email" name="email" placeholder="E-mail" onfocus="this.placeholder=''" onblur="this.placeholder='E-mail'" 
						value="<?php
							if (isset($_SESSION['temp_email']))
							{
								echo $_SESSION['temp_email'];
								unset($_SESSION['temp_email']);
							}
						?>"/>
						<br>
						<span class="red">
							<?php
								if (isset($_SESSION['info_email']))
								{
									echo $_SESSION['info_email'];
									unset($_SESSION['info_email']);
								}
							?>
						</span>
						<br> 
							
						<span><i class="glyphicon glyphicon-lock"></i></span>
						<input required class="input" type="password" name="pass1" placeholder="Password" onfocus="this.placeholder=''" onblur="this.placeholder='Password'"  
						value=""/>
						<br>	
						<br> 
						
						<span><i class="glyphicon glyphicon-lock"></i></span>
						<input required class="input" type="password" name="pass2" placeholder="Repeat password" onfocus="this.placeholder=''" onblur="this.placeholder='Repeat password'" 
						value=""/>
						<br>
						<span class="red">
							<?php
								if (isset($_SESSION['info_pass']))
								{
									echo $_SESSION['info_pass'];
									unset($_SESSION['info_pass']);
								}
							?>
						</span>	
						<br>
						
						
						<button type="submit" class="btn btn-success button">Sign up! <span class="glyphicon glyphicon-log-in"></span></button>
						
					</form>
				<button class="btn btn-primary button" onclick="window.location.href='index.php';"><span class="glyphicon glyphicon-hand-left"></span> Log in!</button>
		</div>

</body>
</html>