<?php
session_start();
include("../../projekt/notLoggedRedirect.php");
require_once "../DBconnect.php";
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>

    <?php include('../includes/base_head.php') ?>

    <!--    datatable styles-->
    <!--    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">-->
    <!--    datatable styles-->
    <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

    <title>Riddles - All riddles</title>

    <script src="../js/delete.js"></script>
    <script src="../js/accept.js"></script>
    <script src="../js/edit.js"></script>

    <script src="../js/dataTable.js"></script>
</head>

<body>
<?php include('../../projekt/includes/navbar.php') ?>
<div class="container">


    <?php
    if (isset($_SESSION['lvl_info'])) {
        echo $_SESSION['lvl_info'];
        unset($_SESSION['lvl_info']);
    }
    $query = "select r.id, r.category, r.description, r.riddle, r.riddle_level, r.author_id, u.login, r.accepted, 
(SELECT count(author_id) from `riddles` where accepted=1), 
(SELECT count(author_id) from `riddles`) from `riddles` r join `users` u on r.author_id = u.id order by r.id"

    ?>

    <main>


        <?php
        $con = @new mysqli($host, $db_user, $db_password, $db_name);


        if ($con->connect_errno != 0) {
            echo "Error: " . $con->connect_errno;
        } else {

        $user = $_SESSION['id'];
        $admin = $_SESSION['admin'];

        $con->set_charset("utf8");


        if ($admin == 1) { ?>
        <table id='sorted-table' class='table table-bordered' cellspacing='0' width='100%'>
            <thead class='table_header'>
            <tr>
                <th>Id</th>
                <th>Category</th>
                <th>Description</th>
                <th>Riddle</th>
                <th>Level</th>
                <th>Author(ID)</th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php
            if ($sql = $con->prepare($query)) {
                $sql->execute();
                $sql->bind_result($id, $category, $description, $riddle, $riddle_level, $author_id, $login, $accepted, $countAccepted, $countAll);


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
                        <td data-target="riddle"><?php echo $riddle ?></td>
                        <td data-target="riddle_level" class="text-center"><?php echo $riddle_level ?></td>
                        <td class="text-center"><?php echo $login ?> (<?php echo $author_id ?>)</td>
                        <td data-target="accepted" class="text-center">
                            <button id="<?php echo $id ?>" class="btn-primary accept"><?php echo $if_accept ?></button>
                        </td>
                        <td class="text-center">
                            <button class="btn-danger"><span id="<?php echo $id ?>"
                                                             class="glyphicon glyphicon-trash button-confirm delete"></span>
                        </td>
                        <td class="text-center">
                            <button id="<?php echo $id ?>" class="btn-warning edit" data-role="edit"><span
                                        id="<?php echo $id ?>" class="glyphicon glyphicon-edit"></span>
                        </td>
                    </tr>

                <?php }
            } else throw new Exception($con->error);

            echo "<div class='subtitle text-center'>All riddles ($countAccepted / $countAll)</div></table>";
            } else echo "You do not have sufficient permissions";

            $con->close();
            }
            ?>
    </main>
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
                    <input type="number" id="riddle_levelModal" class="form-control">
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
</body>
</html>