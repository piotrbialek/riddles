<?php include "addRiddle.php"; ?>
<?php include_once('../projekt/admin/includes/Player.php'); ?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
    <?php include('includes/baseHead.php') ?>
    <title>Riddle - add riddle</title>
</head>
<body>
<?php include('includes/navbar.php') ?>
<div class="container">
    <main class="text-center">
        <div class="formHeader">Add riddle</div>
        <form class="sendForm text-center" method="post" name="formAddRiddle">
            <?php
            if (isset($_SESSION['riddle_added'])) {
                echo $_SESSION['riddle_added'];
                unset($_SESSION['riddle_added']);
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
            <input class="input" type="number" name="riddle_level" min="1" max="100" placeholder="Level (1-100)"
                   onfocus="this.placeholder=''" onblur="this.placeholder='Level (0-100)'"
                   value="<?php
                   if (isset($_SESSION['temp_riddle_level'])) {
                       echo $_SESSION['temp_riddle_level'];
                       unset($_SESSION['temp_riddle_level']);
                   }
                   ?>"/>

            <br>
            <span class="red">
				<?php
                if (isset($_SESSION['info_riddle_level'])) {
                    echo $_SESSION['info_riddle_level'];
                    unset($_SESSION['info_riddle_level']);
                }
                ?>
				</span>
            <br>
            <br>
            <button type="submit" class="btn btn-success button button-add">Add riddle
                <span class="glyphicon glyphicon-plus-sign"></span>
            </button>
        </form>
    </main>
</div>
</body>
</html>