<?php
session_start();
include("../../projekt/notLoggedRedirect.php");
include("includes/User.php");
include("includes/Player.php");
$users = User::findAll();
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
    <?php include('../includes/base_head.php') ?>
    <script type="text/javascript" charset="utf8"
            src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="../js/setAdmin.js"></script>
    <script src="../js/dataTable.js"></script>
    <title>Riddles - All Users</title>
</head>

<body>
<?php include('../../projekt/includes/navbar.php') ?>
<div class="container">
    <main>
        <div class="subtitle text-center">All users</div>
        <?php if ($admin == 1) { ?>
            <table id='sorted-table' class='table table-condensed table-bordered'>
                <thead class='table_header'>
                <th>Id</th>
                <th>Login</th>
                <th>E-mail</th>
                <th>Level</th>
                <th>Type</th>
                </thead>
                <tbody>
                <?php foreach ($users as $user) : ?>
                    <?php
                    if ($user->admin == 1) {
                        $user_type = "<span class='glyphicon glyphicon-star button-confirm yellow'></span>";
                        $admin_class = "admin";
                    } else {
                        $user_type = "<span class='glyphicon glyphicon-user button-confirm gray'></span>";
                        $admin_class = "";
                    }
                    ?>
                    <tr class="<?php echo $admin_class ?>" id="<?php echo $user->id ?>">
                        <td><?php echo $user->id ?></td>
                        <td class="col-lg-4"><?php echo $user->login ?></td>
                        <td class="col-lg-5"><?php echo $user->email ?></td>
                        <td class="text-center col-lg-1"><?php echo $user->level ?></td>
                        <td data-target="user_type" class="text-center">
                            <button id="<?php echo $user->id ?>" class="btn-primary set">
                            <?php echo $user_type ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php } ?>
    </main>
</div>
</body>
</html>