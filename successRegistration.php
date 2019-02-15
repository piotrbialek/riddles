<?php
session_start();

if (!isset($_SESSION['registration_OK'])) {
    header('Location: index.php');
    exit();
} else {
    unset($_SESSION['registration_OK']);
}
if (isset($_SESSION['temp_login'])) unset($_SESSION['temp_login']);
if (isset($_SESSION['temp_email'])) unset($_SESSION['temp_email']);
if (isset($_SESSION['temp_pass1'])) unset($_SESSION['temp_pass1']);
if (isset($_SESSION['temp_pass2'])) unset($_SESSION['temp_pass2']);
if (isset($_SESSION['info_login'])) unset($_SESSION['info_login']);
if (isset($_SESSION['info_email'])) unset($_SESSION['info_email']);
if (isset($_SESSION['info_pass'])) unset($_SESSION['info_pass']);
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
    <?php include('includes/base_head.php') ?>
    <title>Riddles - Successful registration</title>
</head>

<body>
<?php include('includes/navbar.php') ?>
<div class="container text-center">
    <div class="formHeader">Succesful registration</div>
    <main class="sendForm">
        </br>
        Thank you for registering!
        </br>
        Your account was created successfully,
        </br>
        now you can <a href="index.php">log in</a>.
        </br>
        </br>
    </main>
</div>
</body>
</html>
