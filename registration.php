<?php
include_once('../projekt/admin/includes/User.php');
session_start();


if (isset($_POST['email'])) {

    $validation = true;

    $login = $_POST['login'];

    if ((strlen($login) < 3) || (strlen($login) > 20)) {
        $validation = false;
        $_SESSION['info_login'] = "Login must be between 3 and 60 characters!";
    }

    if (ctype_alnum($login) == false) {
        $validation = false;
        $_SESSION['info_login'] = "Login can only consist of alphanumeric characters!";
    }

    $email = $_POST['email'];
    $emailB = filter_var($email, FILTER_SANITIZE_EMAIL);

    if ((filter_var($emailB, FILTER_VALIDATE_EMAIL) == false) || ($emailB != $email)) {
        $validation = false;
        $_SESSION['info_email'] = "Email address is not valid!";
    }

    $pass1 = $_POST['pass1'];
    $pass2 = $_POST['pass2'];

    if (preg_match('/[\'^$%&*()}{@#~?><>,|=_+.;:-]/', $pass1)) {
        $validation = false;
        $_SESSION['info_pass'] = "Password contains invalid characters!";
    }

    if ((strlen($pass1) < 8) || (strlen($pass1) > 20)) {
        $validation = false;
        $_SESSION['info_pass'] = "Password must be between 8 and 20 characters!";
    }

    if ($pass1 != $pass2) {
        $validation = false;
        $_SESSION['info_pass'] = "The passwords are not identical!";
    }

//        ------------------------------------------------------------------------reCAPTCHA
    $secret = "6LcTpmQUAAAAANqO3aGJdZ7_IJM2mp1UgcjC4VsB";
    $checkSecret = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret . '&response=' . $_POST['g-recaptcha-response']);

    $recaptcha = json_decode($checkSecret);

    if (!($recaptcha->success)) {
        $validation = false;
        $_SESSION['info_recaptcha'] = "Confirm that you are not a robot!";
    }

    $_SESSION['temp_login'] = $login;
    $_SESSION['temp_email'] = $email;
    $_SESSION['temp_pass1'] = $pass1;
    $_SESSION['temp_pass2'] = $pass2;

    if ($validation) {
        $pass_hash = password_hash($pass1, PASSWORD_DEFAULT);

        $newUser = new User();
        $newUser->login = $login;
        $newUser->pass = $pass_hash;
        $newUser->email = $email;
        $newUser->level = 0;
        $newUser->admin = 0;

        $usernameExist = User::checkExist('login', $newUser->login);
        $emailExist = User::checkExist('email', $newUser->email);

        if ($usernameExist) {
            $_SESSION['info_login'] = "This login already exists! Choose another one.";
        }

        if ($emailExist) {
            $_SESSION['info_email'] = "There is already an account assigned to this email address!";
        }

        if (!$emailExist && !$usernameExist) {
            $newUser->create();
            $_SESSION['successful_registration'] = "Account created successfully, now you can log in.";
            if (isset($_SESSION['temp_login'])) unset($_SESSION['temp_login']);
            if (isset($_SESSION['temp_email'])) unset($_SESSION['temp_email']);
            if (isset($_SESSION['temp_pass1'])) unset($_SESSION['temp_pass1']);
            if (isset($_SESSION['temp_pass2'])) unset($_SESSION['temp_pass2']);
            if (isset($_SESSION['info_login'])) unset($_SESSION['info_login']);
            if (isset($_SESSION['info_email'])) unset($_SESSION['info_email']);
            if (isset($_SESSION['info_pass'])) unset($_SESSION['info_pass']);
            header('Location: index.php');
        } else $_SESSION['info_recaptcha'] = "There was a problem with creating account.";
    }
}


?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
    <?php include('includes/base_head.php') ?>
    <title>Riddles - registration</title>
    <script src='https://www.google.com/recaptcha/api.js'></script>
</head>
<?php include('includes/navbar.php') ?>
<body>
<div class="container text-center">
			<span class="red">
				<?php
                if (isset($_SESSION['info_server'])) {
                    echo $_SESSION['info_server'];
                    unset($_SESSION['info_server']);
                }
                ?>
			</span>
    <main>
        <div class="formHeader">Registration</div>

        <form class="sendForm" method="post">
            <!--                        nie ma action to plik POSTem wysle do samego siebie?-->

            <br>
            <span><i class="glyphicon glyphicon-user"></i></span>
            <input required class="input" type="text" name="login" placeholder="Login" onfocus="this.placeholder=''"
                   onblur="this.placeholder='Login'"
                   value="<?php
                   if (isset($_SESSION['temp_login'])) {
                       echo $_SESSION['temp_login'];
                       unset($_SESSION['temp_login']);
                   }
                   ?>"/>
            <br>
            <span class="red">
							<?php
                            if (isset($_SESSION['info_login'])) {
                                echo $_SESSION['info_login'];
                                unset($_SESSION['info_login']);
                            }
                            ?>
						</span>
            <br>

            <span><i class="glyphicon glyphicon-envelope"></i></span>
            <input required class="input" type="email" name="email" placeholder="E-mail" onfocus="this.placeholder=''"
                   onblur="this.placeholder='E-mail'"
                   value="<?php
                   if (isset($_SESSION['temp_email'])) {
                       echo $_SESSION['temp_email'];
                       unset($_SESSION['temp_email']);
                   }
                   ?>"/>
            <br>
            <span class="red">
							<?php
                            if (isset($_SESSION['info_email'])) {
                                echo $_SESSION['info_email'];
                                unset($_SESSION['info_email']);
                            }
                            ?>
						</span>
            <br>

            <span><i class="glyphicon glyphicon-lock"></i></span>
            <input required class="input" type="password" name="pass1" placeholder="Password"
                   onfocus="this.placeholder=''"
                   onblur="this.placeholder='Password'"
                   value=""/>
            <br>
            <br>

            <span><i class="glyphicon glyphicon-lock"></i></span>
            <input required class="input" type="password" name="pass2" placeholder="Repeat password"
                   onfocus="this.placeholder=''" onblur="this.placeholder='Repeat password'"
                   value=""/>
            <br>
            <span class="red">
							<?php
                            if (isset($_SESSION['info_pass'])) {
                                echo $_SESSION['info_pass'];
                                unset($_SESSION['info_pass']);
                            }
                            ?>
						</span>
            <br>

            <div class="text-center">
                <div class="g-recaptcha" data-sitekey="6LcTpmQUAAAAAD4zaNCr8luA_JabqWKlWAN-0KTL"></div>
            </div>

            <span class="red">
							<?php
                            if (isset($_SESSION['info_recaptcha'])) {
                                echo $_SESSION['info_recaptcha'];
                                unset($_SESSION['info_recaptcha']);
                            }
                            ?>
						</span>
            <br>


            <button type="submit" class="btn btn-success button">Sign up! <span
                        class="glyphicon glyphicon-log-in"></span>
            </button>

        </form>
    </main>
    <button class="btn btn-primary button" onclick="window.location.href='index.php';"><span
                class="glyphicon glyphicon-hand-left"></span> Log in!
    </button>
</div>

</body>
</html>