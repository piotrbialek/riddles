<?php
session_start();

if ((isset($_SESSION['logged'])) && ($_SESSION['logged'] == true)) {
    header('Location: myRiddles.php');
    exit();
} else {
    $_SESSION['player_level'] = 0;
}

?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
    <?php include('includes/base_head.php') ?>
    <title>Riddles - Log in!</title>
</head>

<body>
<?php include('includes/navbar.php') ?>
<div class="container text-center">
    <main>
        <div class="formHeader">Log in!</div>

        <form class="sendForm" action="login.php" method="post">
            <br>
            <span><i class="glyphicon glyphicon-user"></i></span>
            <input required class="input" type="text" name="login" placeholder="Login" onfocus="this.placeholder=''"
                   onblur="this.placeholder='Login'"
                   value="<?php
                   if (isset($_SESSION['temp_login'])) {
                       echo $_SESSION['temp_login'];
                       unset($_SESSION['temp_login']);
                   }
                   ?>" autofocus/>

            <br>
            <br>

            <span><i class="glyphicon glyphicon-lock"></i></span>
            <input required class="input" type="password" name="pass" placeholder="Password"
                   onfocus="this.placeholder=''" onblur="this.placeholder='Password'"/>

            <br><br>
            <span class="red">
                <?php
                if (isset($_SESSION['login_error'])) echo $_SESSION['login_error'];
                unset($_SESSION['login_error']);
                ?>
		    </span>
            <span class="green">
                <?php
                if (isset($_SESSION['successful_registration'])) echo $_SESSION['successful_registration'];
                unset($_SESSION['successful_registration']);
                ?>
            </span>
            <br><br>
            <a href="registration.php">Don't have an account? Sign up!</a>
            <br>
            <button type="submit" name="submit" class="btn btn-primary button">Log in <span
                        class="glyphicon glyphicon-log-in"></span>
            </button>
            <br>
            <br>
            <a href="notLoggedGame.php">Continue without account</a>

        </form>
    </main>
</div>
</body>
</html>