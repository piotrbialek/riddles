<div class="buttons_group">

    <button class="btn btn-primary button" onclick="window.location.href='../../projekt/singleplayer.php';">PLAY</button>
    <button class="btn btn-primary button" onclick="window.location.href='../../projekt/add.php';">ADD RIDDLE</button>

<?php
		$admin=$_SESSION['admin'];
		if($admin==1)
		{

echo <<< EOT
            <button class='btn btn-primary button' onclick="window.location.href='../../projekt/admin/riddles.php';">ALL RIDDLES</button>
            <button class='btn btn-primary button' onclick="window.location.href='../../projekt/admin/users.php';">ALL USERS</button>
EOT;
		}


?>
</div>