<?php

session_start();

include ("../../projekt/notLoggedRedirect.php");

require_once "../DBconnect.php";

?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
    <?php include('../includes/base_head.php') ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="../js/setAdmin.js"></script>
    <title>Riddles - All Users</title>
</head>

<body>
<div class="container">

    <?php include('../includes/title.php') ?>

    <main>
        <div class="subtitle text-center">All users</div>
        <?php if (isset($_SESSION['admin_info'])) {
            echo $_SESSION['admin_info'];
            unset($_SESSION['admin_info']);
        }
        ?>


        <?php
        $con = @new mysqli($host, $db_user, $db_password, $db_name);


        if ($con->connect_errno != 0) {
            echo "Error: " . $con->connect_errno;
        } else {

            $user = $_SESSION['id'];
            $adminLogin = $_SESSION['login'];
            $adminEmail = $_SESSION['email'];
            $adminLevel = $_SESSION['playerLevel'];
            $admin = $_SESSION['admin'];

            $con->set_charset("utf8");

            if ($admin == 1) {

                echo <<< EOT
						<table class='table table-condensed table-bordered' id='table'>
						<thead class='table_header'>
						    <th>Id</th>
						    <th>Login</th>
						    <th>E-mail</th>
						    <th>Level</th>
						    <th>User type</th>
						    <th>Riddles added</th>
						</thead>
EOT;

                $query = "SELECT u.id, u.login, u.email, u.level, u.admin, count(r.author_id) 
from `users` u join`riddles` r on
 r.author_id = u.id GROUP BY u.id";
//GROUP BY r.author_id";

                $q="SELECT id, login, email, level, admin from users";

//                        "select r.id, r.kategoria, r.opis, r.haslo, r.poziom, r.autor_id, u.login, r.accepted from `riddles` r join `users` u on r.autor_id = u.id"
                if ($sql = $con->prepare($query))//WHERE us.id not like $user
                {
                    $sql->execute();
                    $sql->bind_result($id, $login, $email, $level, $admin, $count);
//                    $sql->bind_result($id, $login, $email, $level, $admin);


                    while ($sql->fetch()) {
                        if ($admin == 1) {
                            $user_type = "<span class='glyphicon glyphicon-star button-confirm yellow'></span>";
                            $admin_class = "admin";
                        } else {
                            $user_type = "<span class='glyphicon glyphicon-user button-confirm gray'></span>";
                            $admin_class = "";
                        }
                        ?>

                        <tr class="<?php echo $admin_class ?>" id="<?php echo $id ?>">
                            <td><?php echo $id ?></td>
                            <td class="col-lg-4"><?php echo $login ?></td>
                            <td class="col-lg-5"><?php echo $email ?></td>
                            <td class="text-center col-lg-1"><?php echo $level ?></td>
                            <td data-target="user_type" class="set text-center" class="col-lg-1">
                                <button id="<?php echo $id ?>" class="btn-primary"><?php echo $user_type ?></td>
                            <td class="text-right"><?php echo $count ?></td>
                        </tr>

                        <?php
                    }
                    $sql->close();
                } else {
                    throw new Exception($con->error);
                }
                echo "</table>";
            } else {
                echo "You do not have sufficient permissions";
            }
            $con->close();
        }
        ?>

    </main>
    <?php include('../includes/buttons.php') ?>

</div>

</body>
</html>