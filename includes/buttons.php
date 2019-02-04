<div class="buttons_group">

    <button class="btn btn-primary button" onclick="window.location.href='../../projekt/riddle.php';">PLAY</button>
    <button class="btn btn-primary button" onclick="window.location.href='../../projekt/addRiddle.php';">ADD RIDDLE</button>

<?php
		$admin=$_SESSION['admin'];
		if($admin==1)
		{

echo <<< EOT
            <button class='btn btn-primary button' onclick="window.location.href='../../projekt/admin/allRiddles.php';">ALL RIDDLES</button>
            <button class='btn btn-primary button' onclick="window.location.href='../../projekt/admin/allUsers.php';">ALL USERS</button>
EOT;
		}


?>
</div>