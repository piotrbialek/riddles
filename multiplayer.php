<?php
session_start();
include_once('../projekt/admin/includes/User.php');
include_once('../projekt/admin/includes/Riddle.php');
include_once('../projekt/admin/includes/Move.php');
include_once('../projekt/admin/includes/Player.php');


if ($_POST) {
    $riddle_id = $_POST['riddle_id'];
    $riddle = Riddle::findById($riddle_id);
    if ($riddle->solved == 0) {
        $riddle->solved = 1;
        if (!$riddle->save()) {
//            var_dump($riddle);
            echo "There is a problem with riddle.";
        }
    } else {


        $user_id = $_SESSION['id'];
        $userResult = 0;

        $riddle = Riddle::findById($riddle_id);
        $move = Move::findByRiddleId($riddle->id);

        $opponent = Player::findById($move->player_id);

        $opponent_user_id = $opponent->user_id;
        $game_id = $move->game_id;

        $player = Player::findGamePlayerId($user_id, $game_id);
        $opponent_player = Player::findGamePlayerId($opponent_user_id, $game_id);

        $player_score = $player->score;
        $opponent_score = $opponent_player->score;

        if ($userResult == 1) {
            $player_score++;
            $opponent_score--;
        } else {
            $player_score--;
            $opponent_score++;
        }

        $player->score = $player_score;
        $opponent_player->score = $opponent_score;

        if (($opponent_player->save()) && ($player->save())) {
            echo "result saved";
        } else echo "problem with saving: " . $riddle->id;


        header("Location: mygames.php");
    }
} else header("Location: mygames.php");


?>


<!DOCTYPE HTML>
<html lang="pl">
<head>

    <?php include('includes/base_head.php') ?>
    <script>
        window.onbeforeunload = function () {

            return $.ajax({
                url: '../../projekt/ajax/leave_multiplayer.php',
                type: 'POST',
                data: {riddle_id: riddle_id},
                success: function (response) {
                    alert(response);
                }
            });
        };
    </script>
    <script type="text/javascript">
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
