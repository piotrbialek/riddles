<?php
include_once('../projekt/admin/includes/Player.php');
include("admin/includes/Riddle.php");
session_start();

if (!isset($_SESSION['logged'])) {
    if (isset($_SESSION['player_level'])) {
        $playerLevel = $_SESSION['player_level'];
    } else {
        header('Location: index.php');
        exit();
    }
} else {
    $login = $_SESSION['login'];
    $playerLevelQuery = "SELECT level FROM users WHERE login='$login'";
}

$riddle = Riddle::drawRiddle($_SESSION['player_level']);
?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
    <?php include('includes/base_head.php') ?>
    <!--    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>-->
    <script type="text/javascript">
        var category = '<?php echo $riddle->category;?>';
        var description = <?php echo json_encode($riddle->description); ?>;
        var riddle = <?php echo json_encode($riddle->riddle); ?>;
    </script>
    <script src="js/skryptRiddle.js"></script>
    <script src="js/checkWinSingleplayer.js"></script>
    <script src="js/gameWonSingleplayer.js"></script>
    <script src="js/increaseLevel.js"></script>
    <script src="js/typed.js" type="text/javascript"></script>
    <title>Riddles</title>
</head>
<body>
<?php include('includes/navbar.php') ?>
<?php include_once('includes/game.php'); ?>
</body>