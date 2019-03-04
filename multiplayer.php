<?php
session_start();
include_once('../projekt/admin/includes/User.php');
include_once('../projekt/admin/includes/Riddle.php');




//$riddle=Riddle::findById(328);
$riddle=Riddle::findById($_POST['riddle_id']);

?>






<!DOCTYPE HTML>
<html lang="pl">
<head>

    <?php include('includes/base_head.php') ?>
    <!--    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>-->
    <script type="text/javascript">
        //var category = '<?php //echo $category;?>//';
        //var description = <?php //echo json_encode($description); ?>//;
        //var riddle = <?php //echo json_encode($riddle); ?>//;


        //var category = '<?php //echo $riddle->getCategory();?>//';
        //var description = <?php //echo json_encode($riddle->getDescription()); ?>//;
        //var riddle = <?php //echo json_encode($riddle->getRiddle()); ?>//;
        var riddleId = '<?php echo $riddle->id;?>';
        var category = '<?php echo $riddle->category;?>';
        var description = <?php echo json_encode($riddle->description); ?>;
        var riddle = <?php echo json_encode($riddle->riddle); ?>;


    </script>
    <script src="js/skryptRiddle.js"></script>
    <script src="js/checkWinMultiplayer.js"></script>
    <script src="js/gameWonMultiplayer.js"></script>
    <script src="js/sendRiddleResult.js"></script>
    <script src="js/typed.js" type="text/javascript"></script>
    <title>Riddles</title>
</head>
<body>
<?php include('includes/navbar.php') ?>
<?php include_once('includes/game.php'); ?>
</body>