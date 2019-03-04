<?php
session_start();

include("../projekt/notLoggedRedirect.php");
include_once("admin/includes/Game.php");
include_once("admin/includes/Player.php");
include_once("admin/includes/Move.php");
include_once("admin/includes/Riddle.php");

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
        <table id='sorted-table' class='table table-bordered'>
            <thead class='table_header'>
            <th>game ID</th>
            <!--            <th class="col-lg-2">initiator</th>-->
            <th class="col-lg-2">play</th>
            </thead>
            <tbody>
            <?php foreach ($games as $game) : ?>
                <?php
                $numberOfPlayers = Player::checkGamePlayers($game->game_id);
                $gameMoves = Move::checkMoveExist($game->game_id);
                $disabled = "";

                $riddleSolved = 0;
                if (count($numberOfPlayers) < 2) {
                    $disabled = "disabled";
                } else {
                    $move = Move::findOpponentsMove($game->game_id, $_SESSION['id']);
                    $riddle = Riddle::findById($move->riddle_id);
                    if ($riddle->solved == 1) $riddleSolved = 1;
                    else $riddleSolved = 0;
                }


//                $move = Move::findOpponentsMove($game->game_id, $_SESSION['id']);
//                $riddleSolved = Riddle::findById($move->riddle_id);


                ?>
                <!--                --><?php //if ((count($gameMoves)>0)&&($riddleSolved->solved==1)) { ?>
                <?php if ((count($gameMoves) > 0) && $riddleSolved==0) { ?>
                    <tr id="<?php echo $game->game_id ?>">
                        <td><?php echo $game->game_id ?></td>
                        <!--                    <td>--><?php //echo $game->player_started_id ?><!--</td>-->
                        <td data-target="join_game" class="text-center">
                            <button class="play_game btn primary" <?php echo $disabled ?>>play</button>
                            <?php echo count($numberOfPlayers) . " in game"; ?>
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