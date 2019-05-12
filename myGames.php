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
        <li role="presentation" class="active"><a href="../../projekt/mygames.php">My games</a></li>
        <li role="presentation"><a href="../../projekt/playedgames.php">Played games</a></li>
        <li role="presentation" class="create_game" id="<?php echo $_SESSION['id']; ?>"><a href="#">Create game</a></li>
    </ul>
    <main>
        <table id='sorted-table' class='table table-bordered'>
            <thead class='table_header'>
            <th class="col-lg-3">ID</th>
            <th class="col-lg-3">Opponent</th>
            <th class="col-lg-3">Play</th>
            </thead>
            <tbody>
            <?php foreach ($games as $game) : ?>
                <?php
                $gameMoves = Move::checkMoveExist($game->game_id);
                $disabled = "";
                $opponentLogin = "";

                $riddleSolved = 0;
                if (count($gameMoves) < 2) {
                    $disabled = "disabled";
                    $opponentLogin = "?";
                } else {
                    $player = Player::findGamePlayerId($_SESSION['id'], $game->game_id);
                    $move = Move::findOpponentsMove($game->game_id, $player->id);
                    $riddle = Riddle::findById($move->riddle_id);
                    if ($riddle->solved == 1) $riddleSolved = 1;
                    else $riddleSolved = 0;

                    $opponent = Player::findById($move->player_id);
                    $opponentUser = User::findById($opponent->user_id);
                    $opponentLogin = $opponentUser->login;
                }
                ?>
                <?php if ((count($gameMoves) > 0) && $riddleSolved == 0) { ?>
                    <tr id="<?php echo $game->game_id ?>">
                        <td><?php echo $game->game_id ?></td>
                        <td><?php echo $opponentLogin ?></td>
                        <td data-target="join_game" class="text-center">
                            <button class="play_game btn btn-primary" <?php echo $disabled ?>>play</button>
                        </td>
                    </tr>
                <?php } ?>
            <?php endforeach; ?>
            </tbody>
        </table>
    </main>
</div>
<?php include('../projekt/includes/multiplayerModal.php') ?>
</body>
</html>