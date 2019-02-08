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
		<title>Riddles - All riddles</title>
		<link rel="stylesheet" href="css/style.css" type="text/css" />
		<link rel="stylesheet" href="css/bootstrap.css" type="text/css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>

        
        <script>
//        $(document).ready(function() {
////    $('#example').DataTable();
//    //$('#users_table').DataTable();
//} );
            
            
        
        </script>
        
        <script type="text/javascript">

        onunload = function()
        {
            var foo = document.getElementById('sort_select');
            self.name = 'fooidx' + foo.selectedIndex;
        }

        onload = function()
        {
            var idx, foo = document.getElementById('sort_select');
            foo.selectedIndex = (idx = self.name.split('fooidx')) ?	idx[1] : 0;
        }

</script>
	</head>

	<body>
		<div class="container" id="container">
            <?php include('includes/title.php') ?>

<?php
                if (isset($_SESSION['lvl_info']))
					{
						echo $_SESSION['lvl_info'];
						unset($_SESSION['lvl_info']);
					}
                if (isset($_POST['value']))
					{
                        $sort= $_POST['value'];
						if ($sort=="id") $query="select r.id, r.category, r.description, r.riddle, r.riddleLevel, r.author_id, u.login, r.accepted, (SELECT count(author_id) from `riddles` where accepted=1), (SELECT count(author_id) from `riddles`) from `riddles` r join `users` u on r.author_id = u.id order by r.id";
                        elseif ($sort=="idD") $query="select r.id, r.category, r.description, r.riddle, r.riddleLevel, r.author_id, u.login, r.accepted, (SELECT count(author_id) from `riddles` where accepted=1), (SELECT count(author_id) from `riddles`) from `riddles` r join `users` u on r.author_id = u.id order by r.id DESC";
                    
                        elseif ($sort=="category") $query="select r.id, r.category, r.description, r.riddle, r.riddleLevel, r.author_id, u.login, r.accepted, (SELECT count(author_id) from `riddles` where accepted=1), (SELECT count(author_id) from `riddles`) from `riddles` r join `users` u on r.author_id = u.id order by r.category";
                        elseif ($sort=="categoryD") $query="select r.id, r.category, r.description, r.riddle, r.riddleLevel, r.author_id, u.login, r.accepted, (SELECT count(author_id) from `riddles` where accepted=1), (SELECT count(author_id) from `riddles`) from `riddles` r join `users` u on r.author_id = u.id order by r.category DESC";
                    
                        elseif ($sort=="description") $query="select r.id, r.category, r.description, r.riddle, r.riddleLevel, r.author_id, u.login, r.accepted, (SELECT count(author_id) from `riddles` where accepted=1), (SELECT count(author_id) from `riddles`) from `riddles` r join `users` u on r.author_id = u.id order by r.description";
                        elseif ($sort=="descriptionD") $query="select r.id, r.category, r.description, r.riddle, r.riddleLevel, r.author_id, u.login, r.accepted, (SELECT count(author_id) from `riddles` where accepted=1), (SELECT count(author_id) from `riddles`) from `riddles` r join `users` u on r.author_id = u.id order by r.description DESC";
                    
                        elseif ($sort=="riddle") $query="select r.id, r.category, r.description, r.riddle, r.riddleLevel, r.author_id, u.login, r.accepted, (SELECT count(author_id) from `riddles` where accepted=1), (SELECT count(author_id) from `riddles`) from `riddles` r join `users` u on r.author_id = u.id order by r.riddle";
                        elseif ($sort=="riddleD") $query="select r.id, r.category, r.description, r.riddle, r.riddleLevel, r.author_id, u.login, r.accepted, (SELECT count(author_id) from `riddles` where accepted=1), (SELECT count(author_id) from `riddles`) from `riddles` r join `users` u on r.author_id = u.id order by r.riddle DESC";
                    
                        elseif ($sort=="level") $query="select r.id, r.category, r.description, r.riddle, r.riddleLevel, r.author_id, u.login, r.accepted, (SELECT count(author_id) from `riddles` where accepted=1), (SELECT count(author_id) from `riddles`) from `riddles` r join `users` u on r.author_id = u.id order by r.riddleLevel";
                        elseif ($sort=="levelD") $query="select r.id, r.category, r.description, r.riddle, r.riddleLevel, r.author_id, u.login, r.accepted, (SELECT count(author_id) from `riddles` where accepted=1), (SELECT count(author_id) from `riddles`) from `riddles` r join `users` u on r.author_id = u.id order by r.riddleLevel DESC";
                    
                        elseif ($sort=="author") $query="select r.id, r.category, r.description, r.riddle, r.riddleLevel, r.author_id, u.login, r.accepted, (SELECT count(author_id) from `riddles` where accepted=1), (SELECT count(author_id) from `riddles`) from `riddles` r join `users` u on r.author_id = u.id order by r.author_id";
                        elseif ($sort=="authorD") $query="select r.id, r.category, r.description, r.riddle, r.riddleLevel, r.author_id, u.login, r.accepted, (SELECT count(author_id) from `riddles` where accepted=1), (SELECT count(author_id) from `riddles`) from `riddles` r join `users` u on r.author_id = u.id order by r.author_id DESC";
                    
                        elseif ($sort=="accepted") $query="select r.id, r.category, r.description, r.riddle, r.riddleLevel, r.author_id, u.login, r.accepted, (SELECT count(author_id) from `riddles` where accepted=1), (SELECT count(author_id) from `riddles`) from `riddles` r join `users` u on r.author_id = u.id WHERE accepted=1 order by r.accepted";
                        elseif ($sort=="NOTaccepted") $query="select r.id, r.category, r.description, r.riddle, r.riddleLevel, r.author_id, u.login, r.accepted, (SELECT count(author_id) from `riddles` where accepted=1), (SELECT count(author_id) from `riddles`) from `riddles` r join `users` u on r.author_id = u.id WHERE accepted=0 order by r.accepted";
                        
					}
                    else $query="select r.id, r.category, r.description, r.riddle, r.riddleLevel, r.author_id, u.login, r.accepted, (SELECT count(author_id) from `riddles` where accepted=1), (SELECT count(author_id) from `riddles`) from `riddles` r join `users` u on r.author_id = u.id order by r.id"
                
?>
<!--
            <form class="text-center" method="post" id="form">
                    <select class="form-control pull-right" id="sort_select" name="value" onchange="this.form.submit()">
                        <option value="id" name="sort" disabled="disabled">Sort</option>
                        <option value="id" name="sort">id</option>
                        <option value="idD" name="sort">id(desc)</option>
                        <option value="category" name="sort">category</option>
                        <option value="categoryD" name="sort">category(Z-A)</option>
                        <option value="description" name="sort">description</option>
                        <option value="descriptionD" name="sort">description(Z-A)</option>
                        <option value="riddle" name="sort">riddle</option>
                        <option value="riddleD" name="sort">riddle(Z-A)</option>
                        <option value="level" name="sort">level</option>
                        <option value="levelD" name="sort">level(desc)</option>
                        <option value="author" name="sort">author</option>
                        <option value="authorD" name="sort">author(desc)</option>
                        <option value="accepted" name="sort">accepted</option>
                        <option value="NOTaccepted" name="sort">NOT accepted</option>
                    </select>
                </form>
-->
			<div>
                <form class="text-center" method="post" id="form">
                    <select class="form-control pull-right" id="sort_select" name="value" onchange="this.form.submit()">
                        <option value="id" name="sort" disabled="disabled">Sort</option>
                        <option value="id" name="sort">id</option>
                        <option value="idD" name="sort">id(desc)</option>
                        <option value="category" name="sort">category</option>
                        <option value="categoryD" name="sort">category(Z-A)</option>
                        <option value="description" name="sort">description</option>
                        <option value="descriptionD" name="sort">description(Z-A)</option>
                        <option value="riddle" name="sort">riddle</option>
                        <option value="riddleD" name="sort">riddle(Z-A)</option>
                        <option value="level" name="sort">level</option>
                        <option value="levelD" name="sort">level(desc)</option>
                        <option value="author" name="sort">author</option>
                        <option value="authorD" name="sort">author(desc)</option>
                        <option value="accepted" name="sort">accepted</option>
                        <option value="NOTaccepted" name="sort">NOT accepted</option>
                    </select>
                </form>
            </div>
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
                        
                        echo "
						<table id='users_table' class='table table-condensed table-bordered'>
                        <thead class='table_header'>
                        <th>Id</th><th>Category</th><th>Description</th><th>Riddle</th><th><span class='glyphicon glyphicon-minus'></span></th><th>Level</th><th><span class='glyphicon glyphicon-plus'></span></th><th>Author(id)</th><th>Accepted</th><th>Accept</th><th>Delete</th>
						</thead>
                        <tbody>
                        ";
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
					else
					{
						echo "You do not have sufficient permissions";
					}
					 $con->close();
				}
?>
			
                
			</div>
        <?php include('includes/buttons.php') ?>
    


		</div>

        
	</body>
</html>