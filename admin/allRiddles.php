<?php

session_start();

if (!isset($_SESSION['logged'])) {
    header('Location: index.php');
    exit();
}

require_once "../DBconnect.php";

?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <title>Riddles - All riddles</title>
    <link rel="stylesheet" href="../css/main.css" type="text/css"/>
    <link rel="stylesheet" href="../css/bootstrap.css" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>

    <script type="text/javascript">

        // onunload = function () {
        //     var foo = document.getElementById('sort_select');
        //     self.name = 'fooidx' + foo.selectedIndex;
        // }
        //
        // onload = function () {
        //     var idx, foo = document.getElementById('sort_select');
        //     foo.selectedIndex = (idx = self.name.split('fooidx')) ? idx[1] : 0;
        // }

    </script>
</head>

<body>
<div class="container" id="container">

    <?php include('../includes/title.php') ?>

    <?php if (isset($_SESSION['accept_info'])) {
        echo $_SESSION['accept_info'];
        unset($_SESSION['accept_info']);
    }
    if (isset($_SESSION['lvl_info'])) {
        echo $_SESSION['lvl_info'];
        unset($_SESSION['lvl_info']);
    }
    $query = "select r.id, r.category, r.description, r.riddle, r.riddleLevel, r.author_id, u.login, r.accepted, 
(SELECT count(author_id) from `riddles` where accepted=1), 
(SELECT count(author_id) from `riddles`) from `riddles` r join `users` u on r.author_id = u.id order by r.id"

    ?>

    <div class="table_content">
                
                
				<?php
				$con = @new mysqli($host, $db_user, $db_password, $db_name);
		
		
				if ($con->connect_errno!=0)
				{
					echo "Error: ".$con->connect_errno;
				}
				else
				{
		
					$user=$_SESSION['id'];
					$admin=$_SESSION['admin'];

					//include "polacz.php";
					$con ->set_charset("utf8");
                    
                    
                    
					if($admin==1)
					{
                        
echo <<< EOT
						<div id="status"></div>
						<table id='example' class='table table-bordered' cellspacing='0' width='100%'>
                        <thead class='table_header'>
                        <th>Id</th><th>Category</th><th>Description</th><th>Riddle</th><th><span class='glyphicon glyphicon-minus'></span></th><th>Level</th><th><span class='glyphicon glyphicon-plus'></span></th><th>Author(id)</th><th>Accepted</th><th>Accept</th><th>Delete</th>
						</thead>
                        <tbody>
EOT;
//							if ($sql = $con->prepare("SELECT id, kategoria, opis, haslo, poziom, autor_id, login, accepted FROM `riddles`, `users`"))
							if ($sql = $con->prepare($query))
									{        
										$sql->execute();
										$sql->bind_result($id, $category, $description, $riddle, $riddleLevel, $author_id, $login, $accepted, $countAccepted, $countAll);

										while ($sql->fetch())
										{
											//$temp_accepted=$accepted;
											if($accepted==1)
											{
												$temp_accepted="accepted";
                                                $tr="";
                                                $if_accept="<span class='glyphicon glyphicon-ban-circle'></span>";
											}
											else
											{
												$temp_accepted="NOT";
                                                $tr="notAccepted";
                                                $if_accept="<span class='glyphicon glyphicon-ok-circle'></span>";
											}
echo <<< EOT
                                            
												<tr class="$tr">
												<td class="text-center">$id</td>
												<td>$category</td>
												<td>$description</td>
												<td>$riddle</td>
                                                <td class="text-center"><button class="btn-danger" onclick='window.location.href="changeLevel.php?id=$id&lvl=$riddleLevel&lvlDown";'><span class='glyphicon glyphicon-minus'></span></td>
												<td class="text-center">$riddleLevel</td>
                                                <td class="text-center"><button class="btn-success" onclick='window.location.href="changeLevel.php?id=$id&lvl=$riddleLevel&lvlUp";'><span class='glyphicon glyphicon-plus'></span></td>        <td class="text-center">$login($author_id)</td>                      
												<td class="text-center">$temp_accepted</td>  
												<td class="text-center"><button class="btn-primary" onclick='window.location.href="accept.php?accept=$id&accepted=$accepted";'>$if_accept</td>         
                                                <td class="text-center"><a href='delete.php?delete=$id' onclick="return confirm('Are you sure you want to delete this item?');"><button class="btn-warning"><span class="glyphicon glyphicon-remove button-confirm"></span></a></td> 
                                                <!--<td class="text-center"><button class="btn-warning" onclick="ajax_post($id, $riddleLevel)"><span class="glyphicon glyphicon-plus"></span></td> -->

												</tr>

                                            
EOT;

										}
echo "</tbody>";
										$sql->close();
									}
									else
									{
										throw new Exception($con->error);
									}
                        echo "<div class='text-center'>All riddles ($countAccepted / $countAll)</div></table>";
					}
					else echo "You do not have sufficient permissions";

					 $con->close();
				}
?>
			
                
			</div>
    <?php include('../includes/buttons.php') ?>


</div>

<script>
    $(document).ready(function () {
        $('#example').DataTable({
            responsive: true,
            "pageLength": 20,
            "pagingType": "numbers",
            "order": [[0, "desc"]]
        });
    });

    function ajax_post(id, level) {
        // Create our XMLHttpRequest object
        var hr = new XMLHttpRequest();
        // Create some variables we need to send to our PHP file
        var url = "../../projekt/ajax/changeRiddleLevel.php";


        var id = id;
        var level = level;
        var changeLvl = true;
        var table = document.getElementById("example").innerHTML;

        var vars = "changeLevel=" + changeLvl + "&id=" + id + "&level=" + level;
        hr.open("POST", url, true);
        // Set content type header information for sending url encoded variables in the request
        hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        // Access the onreadystatechange event for the XMLHttpRequest object
        hr.onreadystatechange = function () {
            if (hr.readyState == 4 && hr.status == 200) {
                var return_data = hr.responseText;
                document.getElementById("status").innerHTML = return_data;
            }
        }
        // Send the data to PHP now... and wait for response to update the status div
        hr.send(vars); // Actually execute the request
        document.getElementById("status").innerHTML = "processing...";
        table.ajax.reload();

    }
</script>


</body>
</html>