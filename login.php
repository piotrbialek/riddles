<?php

	session_start();
	
	if ((!isset($_POST['login'])) || (!isset($_POST['pass'])))
	{
		header('Location: index.php');
		$_SESSION['loginError'] = 'Problem!';
		exit();
	}
	

	require_once "DBconnect.php";

	$connection = @new mysqli($host, $db_user, $db_password, $db_name);
	
	if ($connection->connect_errno!=0)
	{
		echo "Error: ".$connection->connect_errno;
	}
	else
	{
		$login = $_POST['login'];
		$pass = $_POST['pass'];
        

		$login = htmlentities($login, ENT_QUOTES, "UTF-8");
		$pass = htmlentities($pass, ENT_QUOTES, "UTF-8");
        
        $validation=true;
        
        if (ctype_alnum($login)==false)
		{
			
//			$_SESSION['loginError']="Login can only consist of alphanumeric characters!";
            $validation=false;
            header('Location: index.php');
            
		}
        if (ctype_alnum($pass)==false)
		{
			
//			$_SESSION['loginError']="Password can only consist of alphanumeric characters!";
            $validation=false;
            header('Location: index.php');
		}
        
        
	   if ($validation==true)
       {
            if ($rezultat = @$connection->query(
            sprintf("SELECT * FROM users WHERE login='%s'",
            mysqli_real_escape_string($connection,$login))))
            {
                $count_users = $rezultat->num_rows;
                if($count_users>0)
                {
                    $row = $rezultat->fetch_assoc();

                    if (password_verify($pass, $row['pass']))
                    {
                        $_SESSION['logged'] = true;
                        $_SESSION['id'] = $row['id'];
                        $_SESSION['login'] = $row['login'];
                        $_SESSION['pass'] = $row['pass'];
                        $_SESSION['email'] = $row['email'];
                        $_SESSION['playerLevel'] = $row['level'];
                        $_SESSION['admin'] = $row['admin'];


                        unset($_SESSION['loginError']);
                        $rezultat->free_result();
                        header('Location: riddle.php');
                    }
                    else 
                    {
    					$_SESSION['loginError'] = 'Incorrect login or password!';

                        header('Location: index.php');
                    }

                } else {

    				$_SESSION['loginError'] = 'Incorrect login or password!';

                    header('Location: index.php');

                }

            }
        }
        else
        {
            $_SESSION['loginError'] = 'Incorrect login or password!';
        }
		$_SESSION['temp_login'] = $login;
		
		$connection->close();
	}
	
?>