<?php
//-------------------------------------------dodawanie zagadek (tylko zalogowani uzytkownicy)
header('Content-T: text/html; charset=UTF-8');//polskie znaki


session_start();


if (!isset($_SESSION['logged'])) {
    header('Location: index.php');
    exit();
}


if (isset($_POST['sentence'])) {


    $validation = true;

    $category = $_POST['category'];
    $description = $_POST['description'];
    $sentence = $_POST['sentence'];
    $level = $_POST['level'];
    $login = $_SESSION['login'];
    $id = $_SESSION['id'];

    if ((strlen($category) < 3) || (strlen($category) > 20)) {
        $validation = false;
        $_SESSION['info_category'] = "Category must be between 3 and 20 characters!";

    }

    if ((strlen($description) < 3) || (strlen($description) > 60)) {
        $validation = false;
        $_SESSION['info_description'] = "Description must be between 3 and 60 characters!";

    }

    if ((strlen($sentence) < 3) || (strlen($sentence) > 60)) {
        $validation = false;
        $_SESSION['info_sentence'] = "Riddle must be between 3 and 60 characters!";

    }

    if (!preg_match("/^[a-zA-ZżźćńółęąśŻŹĆŃÓŁĘĄŚ ]+$/", $category) == 1) {
        $validation = false;
        $_SESSION['info_category'] = "Category can only consist of letters!";
    }

    if (!preg_match("/^[a-zA-ZżźćńółęąśŻŹĆŃÓŁĘĄŚ ?.,]+$/", $description) == 1) {
        $validation = false;
        $_SESSION['info_description'] = "Description contains inappropriate characters!";
    }

    if (!preg_match("/^[a-zA-ZżźćńółęąśŻŹĆŃÓŁĘĄŚ ]+$/", $sentence) == 1) {
        $validation = false;
        $_SESSION['info_sentence'] = "Riddle can only consist of letters!";
    }

    if ($level > 20 || $level < 0) {
        $validation = false;
        $_SESSION['info_level'] = "Level must be between 0 and 20!";
    }

    if ($level == '' || $level == ' ') {
        $validation = false;
        $_SESSION['info_level'] = "Level could not be empty!";
    }

    $_SESSION['temp_category'] = $category;
    $_SESSION['temp_description'] = $description;
    $_SESSION['temp_sent'] = $sentence;
    $_SESSION['temp_level'] = $level;


    require_once "DBconnect.php";
    mysqli_report(MYSQLI_REPORT_STRICT);

    try {
        $connection = new mysqli($host, $db_user, $db_password, $db_name);
        if ($connection->connect_errno != 0) {
            throw new Exception(mysqli_connect_errno());
        } else {
            if ($validation) {
                $category = mb_strtoupper($category, 'UTF-8');
                $description = mb_strtoupper($description, 'UTF-8');
                $sentence = mb_strtoupper($sentence, 'UTF-8');

                mysqli_query($connection, "SET NAMES 'utf8'");

                if ($connection->query("INSERT INTO riddles VALUES (NULL, '$category', '$description', '$sentence','$level','$id',0)")) {
                    if (isset($_SESSION['category'])) unset($_SESSION['category']);
                    if (isset($_SESSION['description'])) unset($_SESSION['description']);
                    if (isset($_SESSION['sentence'])) unset($_SESSION['sentence']);
                    if (isset($_SESSION['info_category'])) unset($_SESSION['info_category']);
                    if (isset($_SESSION['info_description'])) unset($_SESSION['info_description']);
                    if (isset($_SESSION['info_sentence'])) unset($_SESSION['info_sentence']);
                    if (isset($_SESSION['info_level'])) unset($_SESSION['info_level']);
                    if (isset($_SESSION['temp_category'])) unset($_SESSION['temp_category']);
                    if (isset($_SESSION['temp_description'])) unset($_SESSION['temp_description']);
                    if (isset($_SESSION['temp_sent'])) unset($_SESSION['temp_sent']);
                    if (isset($_SESSION['temp_level'])) unset($_SESSION['temp_level']);
                    $_SESSION['riddleAdded'] = 'Riddle has been added <span class="glyphicon glyphicon-check green"></span>';
                } else {
                    throw new Exception($connection->error);
                }

            }
            $connection->close();
        }
    } catch (Exception $ex) {
        echo '<span class="red">Something goes wrong..</span>';
        echo $ex;
    }
}


?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
    <meta charset="utf-8"/>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="js/skryptAddRiddle.js"></script>
    <title>Riddle - add riddle</title>
    <link rel="stylesheet" href="css/main.css" type="text/css"/>
    <link rel="stylesheet" href="css/bootstrap.css" type="text/css">
</head>
<body>
<div class="container text-center" id="container">

    <?php include('includes/title.php') ?>

    <div class="formHeader">Add riddle</div>

    <form class="sendForm text-center" method="post" name="formAddRiddle">
        <?php
        if (isset($_SESSION['riddleAdded'])) {
            echo $_SESSION['riddleAdded'];
            unset($_SESSION['riddleAdded']);
        }
        ?>
        <br>

        <input class="input" type="text" name="category" placeholder="Category" onfocus="this.placeholder=''"
               onblur="this.placeholder='Category'"
               value="<?php
               if (isset($_SESSION['temp_category'])) {
                   echo $_SESSION['temp_category'];
                   unset($_SESSION['temp_category']);
               }
               ?>"/>

        <br>
        <span style="color:#F31616;">
				<?php
                if (isset($_SESSION['info_category'])) {
                    echo $_SESSION['info_category'];
                    unset($_SESSION['info_category']);
                }
                ?>
				</span>
        <br/>

        <textarea class="input txtArea" type="textarea" name="description" placeholder="Description"
                  onfocus="this.placeholder=''" onblur="this.placeholder='Description'">
<?php
if (isset($_SESSION['temp_description'])) {
    echo $_SESSION['temp_description'];
    unset($_SESSION['temp_description']);
}
?></textarea>
        <br/>
        <span style="color:#F31616;">
				<?php
                if (isset($_SESSION['info_description'])) {
                    echo $_SESSION['info_description'];
                    unset($_SESSION['info_description']);
                }
                ?>
				</span>
        <br>

        <textarea class="input txtArea" type="textarea" name="sentence" placeholder="Riddle"
                  onfocus="this.placeholder=''" onblur="this.placeholder='Riddle'">
<?php
if (isset($_SESSION['temp_sent'])) {
    echo $_SESSION['temp_sent'];
    unset($_SESSION['temp_sent']);
}
?></textarea>
        <br/>
        <span style="color:#F31616;">
				<?php
                if (isset($_SESSION['info_sentence'])) {
                    echo $_SESSION['info_sentence'];
                    unset($_SESSION['info_sentence']);
                }
                ?>
				</span>
        <br>
        <input class="input" type="number" name="level" min="0" max="20" placeholder="Level (0-20)"
               onfocus="this.placeholder=''" onblur="this.placeholder='Level (0-20)'"
               value="<?php
               if (isset($_SESSION['temp_level'])) {
                   echo $_SESSION['temp_level'];
                   unset($_SESSION['temp_level']);
               }
               ?>"/>

        <br>
        <span style="color:#F31616;">
				<?php
                if (isset($_SESSION['info_level'])) {
                    echo $_SESSION['info_level'];
                    unset($_SESSION['info_level']);
                }
                ?>
				</span>
        <br>
        <br>
        <button class="btn btn-danger button" onclick="reset();" id="resetBtn">Clear the form <span
                    class="glyphicon glyphicon-remove-circle"></span></button>
        <button type="submit" class="btn btn-success button">Add riddle <span
                    class="glyphicon glyphicon-plus-sign"></span></button>

    </form>
    <br>
    <?php include('includes/buttons.php') ?>


</div>


</body>
</html>