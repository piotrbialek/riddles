<?php

session_start();

include ("../projekt/notLoggedRedirect.php");

require_once "DBconnect.php";

?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
    <?php include ('includes/base_head.php') ?>
    <title>Riddles - my Riddles</title>
</head>

<body>
<div class="container">
    <?php include('../projekt/includes/title.php') ?>

    <main>
        <?php
        $con = @new mysqli($host, $db_user, $db_password, $db_name);


        if ($con->connect_errno != 0) {
            echo "Error: " . $con->connect_errno;
        } else {

            $user = $_SESSION['id'];
            $admin = $_SESSION['admin'];

            $query = "SELECT id, category, description, riddle, riddleLevel, (
                    SELECT count(ri.author_id) from `riddles` ri join `users` us on ri.author_id = us.id 
                    where us.id=$user GROUP by ri.author_id), (SELECT count(ri.author_id) 
                    from `riddles` ri join `users` us on ri.author_id = us.id 
                    where us.id=$user and ri.accepted=1) FROM `riddles` WHERE author_id=$user";


            $con->set_charset("utf8");
            if ($stmt = $con->prepare($query)) {
                $stmt->execute();
                $stmt->store_result();
                if ($stmt->num_rows > 0) {
                    echo "
						<table class='table table-bordered table-condensed' id='table'>
						<tr>
						<th>Category</th><th>Description</th><th>Riddle</th><th>Level</th>
						</tr>";
                    //if ($sql = $con->prepare($query)) {
                    //$sql->execute();
                    $stmt->bind_result($id, $category, $description, $riddle, $riddleLevel, $myRiddles, $myRiddlesA);

                    while ($stmt->fetch()) {
                        echo <<< EOT
										
											<tr>
											<td>$category</td>
											<td>$description</td>
											<td>$riddle</td>  													
											<td class="text-center">$riddleLevel</td>  													
											</tr>
EOT;
                    }
                    $stmt->close();
                    //}
                    echo "<div class='text-center'>My riddles($myRiddlesA / $myRiddles)</div></table>";
                } else {
                    echo "You have not added any riddles yet";
                }
            }

            $con->close();
        }
        ?>

    </main>
    <?php include('../projekt/includes/buttons.php') ?>

</div>

</body>
</html>