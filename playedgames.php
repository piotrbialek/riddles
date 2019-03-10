<?php
session_start();

include("../projekt/notLoggedRedirect.php");
include_once("admin/includes/Game.php");
include_once("admin/includes/Player.php");
include_once("admin/includes/Move.php");
include_once("admin/includes/Riddle.php");
include_once("admin/includes/User.php");

$games = Player::findMyGames($_SESSION['id']);
$player_score = Player::getPlayerScore($_SESSION['id']);

?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
    <?php include('includes/base_head.php') ?>
    <script type="text/javascript" charset="utf8"
            src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="js/dataTable.js"></script>
    <script src="js/play_game.js"></script>
    <script src="js/create_game.js"></script>
    <title>Riddles - Multi player</title>
</head>

<body>
<?php include('../projekt/includes/navbar.php') ?>
<div class="container">

    <main>
        <div class="subtitle text-center">Played Games</div>
        <div class="text-center">score: <?php echo $player_score; ?></div>
        <button onclick="window.location.href='../../projekt/games.php';">available games</button>
        <button onclick="window.location.href='../../projekt/mygames.php';">my games</button>
        <table id='sorted-table' class='table table-bordered'>
            <thead class='table_header'>
            <th>game ID</th>
            <!--            <th class="col-lg-2">initiator</th>-->
            <th class="col-lg-2">opp</th>
            <th class="col-lg-2">score</th>
            </thead>
            <tbody>
            <?php foreach ($games as $game) : ?>
                <?php
                $gameMoves = Move::checkMoveExist($game->game_id);
                if ((count($gameMoves) == 2)) {

                    $player = Player::findGamePlayerId($_SESSION['id'], $game->game_id);

                    $opponentMove = Move::findOpponentsMove($game->game_id, $player->id);
                    $playerMove = Move::findOpponentsMove($game->game_id, $opponentMove->player_id);

                    $opponent_riddle = Riddle::findById($opponentMove->riddle_id);
                    $player_riddle = Riddle::findById($playerMove->riddle_id);

                    $opponent = Player::findById($opponentMove->player_id);
                    $opponentUser = User::findById($opponent->user_id);


                    if (($opponent_riddle->solved == 1) && ($player_riddle->solved == 1)) {
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
</body>
</html>