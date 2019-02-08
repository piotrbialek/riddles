<?php

include "add.php";


?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
    <?php include('includes/base_head.php') ?>
    <title>Riddle - add riddle</title>
</head>
<body>
<div class="container text-center">

    <?php include('includes/title.php') ?>
    <main>
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
            <span class="red">
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
            <span class="red">
				<?php
                if (isset($_SESSION['info_description'])) {
                    echo $_SESSION['info_description'];
                    unset($_SESSION['info_description']);
                }
                ?>
				</span>
            <br>

            <textarea class="input txtArea" type="textarea" name="riddle" placeholder="Riddle"
                      onfocus="this.placeholder=''" onblur="this.placeholder='Riddle'">
<?php
if (isset($_SESSION['temp_riddle'])) {
    echo $_SESSION['temp_riddle'];
    unset($_SESSION['temp_riddle']);
}
?></textarea>
            <br/>
            <span class="red">
				<?php
                if (isset($_SESSION['info_riddle'])) {
                    echo $_SESSION['info_riddle'];
                    unset($_SESSION['info_riddle']);
                }
                ?>
				</span>
            <br>
            <input class="input" type="number" name="riddleLevel" min="0" max="20" placeholder="Level (0-20)"
                   onfocus="this.placeholder=''" onblur="this.placeholder='Level (0-20)'"
                   value="<?php
                   if (isset($_SESSION['temp_riddleLevel'])) {
                       echo $_SESSION['temp_riddleLevel'];
                       unset($_SESSION['temp_riddleLevel']);
                   }
                   ?>"/>

            <br>
            <span class="red">
				<?php
                if (isset($_SESSION['info_riddleLevel'])) {
                    echo $_SESSION['info_riddleLevel'];
                    unset($_SESSION['info_riddleLevel']);
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
    </main>
    <br>
    <?php include('includes/buttons.php') ?>


</div>


</body>
</html>