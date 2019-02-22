<?php
session_start();
include("../../projekt/notLoggedRedirect.php");
include("includes/Riddle.php");
include("includes/User.php");
$riddles = Riddle::findAll();
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>

    <?php include('../includes/base_head.php') ?>

    <!--    datatable styles-->
    <!--    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">-->
    <!--    datatable styles-->
    <script type="text/javascript" charset="utf8"
            src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

    <title>Riddles - All riddles</title>

    <script src="../js/delete.js"></script>
    <script src="../js/accept.js"></script>
    <script src="../js/edit.js"></script>

    <script src="../js/dataTable.js"></script>
</head>

<body>
<?php include('../../projekt/includes/navbar.php') ?>
<div class="container">

    <main>
        <div class='subtitle text-center'>All riddles</div>

        <?php if ($admin == 1) { ?>
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
                <?php foreach ($riddles as $riddle) : ?>
                    <?php
                    if ($riddle->accepted == 1) {
                        $tr = "";
                        $if_accept = "<span class='glyphicon glyphicon-ban-circle'></span>";
                    } else {
                        $tr = "notAccepted";
                        $if_accept = "<span class='glyphicon glyphicon-ok-circle'></span>";
                    }
                    ?>
                    <tr class="<?php echo $tr ?>" id="<?php echo $riddle->id ?>">
                        <td><?php echo $riddle->id ?></td>
                        <td data-target="category"><?php echo $riddle->category ?></td>
                        <td data-target="description"><?php echo $riddle->description ?></td>
                        <td data-target="riddle"><?php echo $riddle->riddle ?></td>
                        <td data-target="riddle_level" class="text-center"><?php echo $riddle->riddle_level ?></td>
                        <td data-target="author_id">
                            <?php echo $login = User::getUsernameById($riddle->author_id) ?>(<?php echo $riddle->author_id ?>)
                        </td>
                        <td data-target="accepted" id="<?php echo $riddle->accepted ?>" class="text-center">
                            <button id="<?php echo $riddle->id ?>" class="btn-primary accept">
                                <?php echo $if_accept ?>
                            </button>
                        </td>
                        <td class="text-center">
                            <button class="btn-danger">
                                <span id="<?php echo $riddle->id ?>" class="glyphicon glyphicon-trash button-confirm delete"></span>
                            </button>
                        </td>
                        <td class="text-center">
                            <button id="<?php echo $riddle->id ?>" class="btn-warning edit" data-role="edit">
                                <span id="<?php echo $riddle->id ?>" class="glyphicon glyphicon-edit"></span>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php } ?>

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
                    <label for="categoryModal">Category (3-20 characters)</label>
                    <input type="text" id="categoryModal" class="form-control">
                </div>

                <div class="form-group">
                    <label for="descriptionModal">Description (3-60 characters)</label>
                    <input type="text" id="descriptionModal" class="form-control">
                </div>

                <div class="form-group">
                    <label for="riddleModal">Riddle (3-60 characters)</label>
                    <input type="text" id="riddleModal" class="form-control">
                </div>

                <div class="form-group">
                    <label for="riddle_levelModal">Level (1-100)</label>
                    <input type="number" id="riddle_levelModal" class="form-control">
                </div>
                <input type="hidden" id="riddle_idModal" class="form-control">
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