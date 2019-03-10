<?php
session_start();

include("../projekt/notLoggedRedirect.php");
include_once("admin/includes/Game.php");
include_once("admin/includes/Player.php");
include_once("admin/includes/Move.php");
include_once("admin/includes/Riddle.php");
include_once("admin/includes/User.php");

//$games = Game::findAll();
$games = Player::findMyGames($_SESSION['id']);

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
        <div class="subtitle text-center">My Games</div>
        <button onclick="window.location.href='../../projekt/games.php';">available games</button>
        <button onclick="window.location.href='../../projekt/playedgames.php';">played games</button>
        <table id='sorted-table' class='table table-bordered'>
            <thead class='table_header'>
            <th>game ID</th>
            <th>opponent</th>
            <th class="col-lg-2">play</th>
            </thead>
            <tbody>
            <?php foreach ($games as $game) : ?>
                <?php
//                $numberOfPlayers = Player::checkGamePlayers($game->game_id);
                $gameMoves = Move::checkMoveExist($game->game_id);
                $disabled = "";

                $riddleSolved = 0;
                if (count($gameMoves) < 2) {
                    $disabled = "disabled";
                } else {
                    $player=Player::findGamePlayerId($_SESSION['id'], $game->game_id);
                    $move = Move::findOpponentsMove($game->game_id, $player->id);
                    $riddle = Riddle::findById($move->riddle_id);
                    if ($riddle->solved == 1) $riddleSolved = 1;
                    else $riddleSolved = 0;

                    $opponent = Player::findById($move->player_id);
                    $opponentUser = User::findById($opponent->user_id);
                }

                ?>
                <?php if ((count($gameMoves) == 2) && $riddleSolved==0) { ?>
<!--                --><?php //if ($riddleSolved==0) { ?>
                    <tr id="<?php echo $game->game_id ?>">
                        <td><?php echo $game->game_id ?></td>
                        <td><?php echo $opponentUser->login ?></td>
                        <!--                    <td>--><?php //echo $game->player_started_id ?><!--</td>-->
                        <td data-target="join_game" class="text-center">
                            <button class="play_game btn primary" <?php echo $disabled ?>>play</button>
                            <?php echo count($gameMoves) . "moves in game"; ?>
<!--                            --><?php //echo count($numberOfPlayers) . " pl in game"; ?>
<!--                            --><?php //echo $riddle->solved . " solved"; ?>
                        </td>
                    </tr>
                <?php } ?>
            <?php endforeach; ?>
            </tbody>
        </table>
    </main>
</div>
</body>
</html>