<div class="buttons_group">
                    <button class="btn btn-primary button" onclick="window.location.href='riddle.php';">PLAY</button>
		            <button class="btn btn-primary button" onclick="window.location.href='addRiddle.php';">ADD RIDDLE</button>
<?php
		$admin=$_SESSION['admin'];
		if($admin==1)
		{
            $allRiddles="window.location.href='allRiddles.php';";
            $allUsers="window.location.href='allUsers.php';";
            echo "<button class='btn btn-primary button' onclick=".$allRiddles.">ALL RIDDLES</button>";
            echo "<button class='btn btn-primary button' onclick=".$allUsers.">ALL USERS</button>";
		}


?>
		</div>