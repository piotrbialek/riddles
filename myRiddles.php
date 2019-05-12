<?php
session_start();
include_once('../projekt/admin/includes/Player.php');
include("../projekt/notLoggedRedirect.php");
include("admin/includes/Riddle.php");
$riddles = Riddle::findMyRiddles($_SESSION["id"]);
if (!$riddles) $_SESSION['riddle_problem'] = '<span class="red">You have not added any riddles yet.</span>';
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
    <?php include('includes/base_head.php') ?>
    <script type="text/javascript" charset="utf8"
            src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="js/dataTable.js"></script>
    <title>Riddles - my riddles</title>
</head>

<body>
<?php include('includes/navbar.php') ?>
<div class="container">
    <?php
    if (isset($_SESSION['riddle_problem'])) {
        echo $_SESSION['riddle_problem'];
        unset($_SESSION['riddle_problem']);
    } ?>
    <main>
        <div class='subtitle text-center'>My riddles</div>
        <table id='sorted-table' class='table table-bordered table-condensed'>
            <thead class='table_header'>
            <th>Category</th>
            <th>Description</th>
            <th>Riddle</th>
            <th>Level</th>
            </thead>
            <tbody>
            <?php foreach ($riddles as $riddle) : ?>
                <tr>
                    <td><?php echo $riddle->category; ?></td>
                    <td><?php echo $riddle->description; ?></td>
                    <td><?php echo $riddle->riddle; ?></td>
                    <td><?php echo $riddle->riddle_level; ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </main>
</div>
</body>
</html>