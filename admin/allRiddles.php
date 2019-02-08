<?php

session_start();

include ("../../projekt/notLoggedRedirect.php");

require_once "../DBconnect.php";

//include "../ajax/edit.php";


?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
    <?php include('../includes/base_head.php') ?>
    <title>Riddles - All riddles</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>


    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


    <script src="../js/delete.js"></script>
    <script src="../js/accept.js"></script>
    <script src="../js/edit.js"></script>

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
<div class="container">

    <?php include('../includes/title.php') ?>

    <?php
    if (isset($_SESSION['lvl_info'])) {
        echo $_SESSION['lvl_info'];
        unset($_SESSION['lvl_info']);
    }
    $query = "select r.id, r.category, r.description, r.riddle, r.riddleLevel, r.author_id, u.login, r.accepted, 
(SELECT count(author_id) from `riddles` where accepted=1), 
(SELECT count(author_id) from `riddles`) from `riddles` r join `users` u on r.author_id = u.id order by r.id"

    ?>

    <main class="table_content">


        <?php
        $con = @new mysqli($host, $db_user, $db_password, $db_name);


        if ($con->connect_errno != 0) {
            echo "Error: " . $con->connect_errno;
        } else {

            $user = $_SESSION['id'];
            $admin = $_SESSION['admin'];

            $con->set_charset("utf8");


            if ($admin == 1) {

                echo <<< EOT
						<table id='example' class='table table-bordered' cellspacing='0' width='100%'>
                        <thead class=""table_header">
                            <tr>
                                <th>Id</th>
                                <th>Category</th>
                                <th>Description</th>
                                <th>Riddle</th>
                                <th>Level</th>
                                <th>Author (ID)</th>
                                <th>Accepted</th>
                            </tr>
                        </thead>
                        <tbody>
EOT;
//							if ($sql = $con->prepare("SELECT id, kategoria, opis, haslo, poziom, autor_id, login, accepted FROM `riddles`, `users`"))
//                if ($sql = $con->prepare($query)) {
//                    $sql->execute();
//                    $sql->bind_result($id, $category, $description, $riddle, $riddleLevel, $author_id, $login, $accepted, $countAccepted, $countAll);
//
//                    while ($sql->fetch()) {
//                        //$temp_accepted=$accepted;
//                        if ($accepted == 1) {
//                            $temp_accepted = "accepted";
//                            $tr = "";
//                            $if_accept = "<span class='glyphicon glyphicon-ban-circle'></span>";
//                        } else {
//                            $temp_accepted = "NOT";
//                            $tr = "notAccepted";
//                            $if_accept = "<span class='glyphicon glyphicon-ok-circle'></span>";
//                        }
//                        echo <<< EOT
//
//						<tr id="$id" class="$tr">
//                            <td class="text-center">$id</td>
//                            <td>$category</td>
//                            <td>$description</td>
//                            <td>$riddle</td>
//                            <td class="text-center"><button class="btn-danger" onclick='window.location.href="changeLevel.php?id=$id&lvl=$riddleLevel&lvlDown";'><span class='glyphicon glyphicon-minus'></span></td>
//                            <td class="text-center">$riddleLevel</td>
//                            <td class="text-center"><button class="btn-success" onclick='window.location.href="changeLevel.php?id=$id&lvl=$riddleLevel&lvlUp";'><span class='glyphicon glyphicon-plus'></span></td>
//                            <td class="text-center">$login($author_id)</td>
//                            <td data-target="accepted" class="text-center">$temp_accepted</td>
//                            <!--<td class="text-center"><button class="btn-primary" onclick='window.location.href="accept.php?accept=$id&accepted=$accepted";'>$if_accept</td>          -->
//
//
//                            <td class="text-center" id=$accepted><button id=$id class="btn-primary accept">$if_accept</button></td>
//
//
//                            <td class="text-center"><button class="btn-warning"><span id=$id class="glyphicon glyphicon-remove button-confirm delete"></span></td>
//						</tr>
//EOT;
//                    }
//                    echo "</tbody>";
//                    $sql->close();
//                } else {
//                    throw new Exception($con->error);
//                }
        if ($sql = $con->prepare($query)) {
            $sql->execute();
            $sql->bind_result($id, $category, $description, $riddle, $riddleLevel, $author_id, $login, $accepted, $countAccepted, $countAll);


            while ($sql->fetch()) {
                if ($accepted == 1) {
                    $temp_accepted = "accepted";
                    $tr = "";
                    $if_accept = "<span class='glyphicon glyphicon-ban-circle'></span>";
                } else {
                    $temp_accepted = "NOT";
                    $tr = "notAccepted";
                    $if_accept = "<span class='glyphicon glyphicon-ok-circle'></span>";
                }

                ?>

                <tr class="<?php echo $tr ?>" id="<?php echo $id ?>">
                    <td><?php echo $id ?></td>
                    <td data-target="category"><?php echo $category ?></td>
                    <td data-target="description"><?php echo $description ?></td>
                    <td data-target="riddle"><?php echo $riddle?></td>
                    <td data-target="riddleLevel" class="text-center"><?php echo $riddleLevel ?></td>
                    <td class="text-center"><?php echo $login?> (<?php echo $author_id ?>)</td>
                    <td data-target="accepted" class="text-center accept" id="<?php echo $accepted ?>"><button id="<?php echo $id ?>" class="btn-primary"><?php echo $if_accept ?></button></td>
                    <td class="text-center"><button class="btn-warning"><span id="<?php echo $id ?>" class="glyphicon glyphicon-remove button-confirm delete"></span></td>
                    <td><a href="javascript:;" data-role="update" data-id="<?php echo $id ?>">Edit</a></td>
                </tr>

            <?php }
        } else throw new Exception($con->error);

                echo "<div class='subtitle text-center'>All riddles ($countAccepted / $countAll)</div></table>";
            } else echo "You do not have sufficient permissions";

            $con->close();
        }
        ?>
    </main>
    <?php include('../includes/buttons.php') ?>


</div>
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Category (3-20 characters)</label>
                    <input type="text" id="categoryModal" class="form-control">
                </div>

                <div class="form-group">
                    <label>Description (3-60 characters)</label>
                    <input type="text" id="descriptionModal" class="form-control">
                </div>

                <div class="form-group">
                    <label>Riddle (3-60 characters)</label>
                    <input type="text" id="riddleModal" class="form-control">
                </div>

                <div class="form-group">
                    <label>Level (1-20)</label>
                    <input type="number" id="riddleLevelModal" class="form-control">
                </div>

                <input type="hidden" id="riddleIdModal" class="form-control">


            </div>
            <div class="modal-footer">
                <a href="javascript:;" id="save" class="btn btn-primary pull-right">Update</a>
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
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





</script>

</body>
</html>