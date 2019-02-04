<header class="title text-center">
				<div id="user">
				<?php 
//				session_start();
                   if (!isset($_SESSION['logged']))
	               {
                     echo '<a href="../../projekt/index.php">Log in</a> or <a href="../../projekt/registration.php">Sign up</a>';
                       
                    }
                    else
                    {
                    echo '<a href="../../projekt/myRiddles.php">' .$_SESSION['login']. '</a> (<a href="../../projekt/logout.php">log out</a>)<br>';
                    echo 'Level:'.$_SESSION['playerLevel'];
                    }
                    ?>
				
				
				

				</div>
				Riddles
</header>