<header id="title" class="text-center"> 
				<div id="user">
				<?php 
//				session_start();
                   if (!isset($_SESSION['logged']))
	               {
                     echo '<a href="index.php">Log in</a> or <a href="registration.php">Sign up</a>';
                       
                    }
                    else
                    {
                    echo '<a href="myRiddles.php">'.$_SESSION['login'].'</a> (<a href="logout.php">log out</a>)<br>';
                    echo 'Level:'.$_SESSION['playerLevel'];
                    }
                    ?>
				
				
				

				</div>
				Riddles
</header>