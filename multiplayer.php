<?php
session_start();
include_once('../projekt/admin/includes/User.php');
include_once('../projekt/admin/includes/Riddle.php');
include_once('../projekt/admin/includes/Move.php');
include_once('../projekt/admin/includes/Player.php');


if ($_POST) {
    $riddleId = $_POST['riddle_id'];
    $riddle = Riddle::findById($riddleId);
    if ($riddle->solved == 0) {
        $riddle->solved = 1;
        if (!$riddle->save()) {
            echo "There is a problem with riddle.";
        }
    } else {

        $userId = $_SESSION['id'];
        $userResult = 0;

        $riddle = Riddle::findById($riddleId);
        $move = Move::findByRiddleId($riddle->id);

        $opponent = Player::findById($move->player_id);

        $opponentUserId = $opponent->user_id;
        $gameId = $move->game_id;

        $player = Player::findGamePlayerId($userId, $gameId);
        $opponentPlayer = Player::findGamePlayerId($opponentUserId, $gameId);

        $playerScore = $player->score;
        $opponentScore = $opponentPlayer->score;

        if ($userResult == 1) {
            $playerScore++;
            $opponentScore--;
        } else {
            $playerScore--;
            $opponentScore++;
        }

        $player->score = $playerScore;
        $opponentPlayer->score = $opponentScore;

        if (($opponentPlayer->save()) && ($player->save())) {
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
