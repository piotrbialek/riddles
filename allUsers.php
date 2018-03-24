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
		<title>Riddles - All Users</title>
		<link rel="stylesheet" href="style.css" type="text/css" />
		<link rel="stylesheet" href="css/bootstrap.css" type="text/css">
	</head>

	<body>
		<div class="container" id="container">

            <?php include ('title.php') ?>

          
			<div>
                <div>
                
<?php           if (isset($_SESSION['admin_info']))
					{
						echo $_SESSION['admin_info'];
						unset($_SESSION['admin_info']);
					}
?>
                </div>

				<?php
				$con = @new mysqli($host, $db_user, $db_password, $db_name);
		
		
				if ($con->connect_errno!=0)
				{
					echo "Error: ".$con->connect_errno;
				}
				else
				{
		
					$user=$_SESSION['id'];
					$adminLogin=$_SESSION['login'];
					$adminEmail=$_SESSION['email'];
					$adminLevel=$_SESSION['playerLevel'];
					$admin=$_SESSION['admin'];

					$con ->set_charset("utf8");

					if($admin==1)
					{
						echo "Administrator manages all the users";
						echo "
						<table class='table table-condensed table-bordered' id='table'>
						<thead class='table_header'>
						<th>Id</th><th>Login</th><th>E-mail</th><th>Level</th><th>User type</th><th></th><th>Riddles added</th>
						</thead>";
//                        "select r.id, r.kategoria, r.opis, r.haslo, r.poziom, r.autor_id, u.login, r.accepted from `riddles` r join `users` u on r.autor_id = u.id"
							if ($sql = $con->prepare("SELECT us.id, us.login, us.email, us.level, us.admin, count(ri.author_id) from `riddles` ri join `users` us on ri.author_id = us.id GROUP by ri.author_id"))//WHERE us.id not like $user
									{        
										$sql->execute();
										$sql->bind_result($id, $login, $email, $level, $admin, $count);

										while ($sql->fetch())
										{
											if($admin==1)
											{
												$temp_admin="<span class='glyphicon glyphicon-star-empty'></span>";
                                                $user_type="<span class='glyphicon glyphicon-user button-confirm'></span>";
											}
											else
											{
												$temp_admin="<span class='glyphicon glyphicon-user'></span>";
                                                $user_type="<span class='glyphicon glyphicon-star-empty button-confirm'></span>";
											}
											echo <<< EOT
												<tr>
												<td>$id</td>
												<td class="col-lg-4">$login</td>
												<td class="col-lg-5">$email</td>
												<td class="text-center col-lg-1">$level</td>                      
												<td class="text-center col-lg-1">$temp_admin</td>                                           
												<td class="text-center class="col-lg-1""><a href='setAdmin.php?setAdmin=$id&admin=$admin' onclick="return confirm('Are you sure you want to change the administrator rights of the user $login?');"><button class="btn-primary">$user_type</a></td> 
                                                <td class="text-right">$count</td>
												</tr>
                                               
EOT;
										}
										$sql->close();
									}
									else
									{
										throw new Exception($con->error);
									}
                        echo "</table>";
					}
					else
					{
						echo "You do not have sufficient permissions";
					}
					 $con->close();
				}
?>

			</div>
			<?php include ('buttons.php') ?>

		</div>

	</body>
</html>