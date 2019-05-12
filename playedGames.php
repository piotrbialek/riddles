<?php
session_start();

include("../projekt/notLoggedRedirect.php");
include_once("admin/includes/Game.php");
include_once("admin/includes/Player.php");
include_once("admin/includes/Move.php");
include_once("admin/includes/Riddle.php");
include_once("admin/includes/User.php");

$games = Player::findMyGames($_SESSION['id']);

?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
    <?php include('includes/baseHead.php') ?>
    <script type="text/javascript" charset="utf8"
            src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="js/dataTable.js"></script>
    <script src="js/playGame.js"></script>
    <script src="js/createGame.js"></script>
    <title>Riddles - Multi player</title>
</head>
<body>
<?php include('../projekt/includes/navbar.php') ?>
<div class="container">
    <ul class="nav nav-tabs nav-justified">
        <li role="presentation"><a href="../../projekt/games.php">Available games</a></li>
        <li role="presentation"><a href="../../projekt/mygames.php">My games</a></li>
        <li role="presentation" class="active"><a href="../../projekt/playedgames.php">Played games</a></li>
        <li role="presentation" class="create_game" id="<?php echo $_SESSION['id']; ?>"><a href="#">Create game</a></li>
    </ul>
    <main>
        <table id='sorted-table' class='table table-bordered'>
            <thead class='table_header'>
            <th class="col-lg-3">ID</th>
            <th class="col-lg-3">Opponent</th>
            <th class="col-lg-3">Result</th>
            </thead>
            <tbody>
            <?php foreach ($games as $game) : ?>
                <?php
                $gameMoves = Move::checkMoveExist($game->game_id);
                if ((count($gameMoves) == 2)) {

                    $player = Player::findGamePlayerId($_SESSION['id'], $game->game_id);

                    $opponentMove = Move::findOpponentsMove($game->game_id, $player->id);
                    $playerMove = Move::findOpponentsMove($game->game_id, $opponentMove->player_id);

                    $opponentRiddle = Riddle::findById($opponentMove->riddle_id);
                    $playerRiddle = Riddle::findById($playerMove->riddle_id);

                    $opponent = Player::findById($opponentMove->player_id);
                    $opponentUser = User::findById($opponent->user_id);

                    if (($opponentRiddle->solved == 1) && ($playerRiddle->solved == 1)) {
                        ?>

                        <tr id="<?php echo $game->game_id ?>">
                            <td><?php echo $game->game_id ?></td>
                            <td><?php echo $opponentUser->login ?></td>
                            <td><?php echo $game->score ?></td>
                        </tr>
                    <?php }
                } ?>
            <?php endforeach; ?>
            </tbody>
        </table>
    </main>
</div>
<?php include('../projekt/includes/multiplayerModal.php') ?>
</body>
</html>