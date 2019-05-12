<?php
session_start();

include("../projekt/notLoggedRedirect.php");
include_once("admin/includes/Game.php");
include_once("admin/includes/Player.php");
include_once("admin/includes/Move.php");
include_once("admin/includes/User.php");

$games = Game::findAll();

?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
    <?php include('includes/base_head.php') ?>
    <script type="text/javascript" charset="utf8"
            src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="js/dataTable.js"></script>
    <script src="js/join_game.js"></script>
    <script src="js/create_game.js"></script>
    <script>
        $('#myModal').modal({
            backdrop: 'static',
            keyboard: false
        });
    </script>
    <title>Riddles - Multi player</title>
</head>
<body>
<?php include('../projekt/includes/navbar.php') ?>

<div class="container">
    <ul class="nav nav-tabs nav-justified">
        <li role="presentation" class="active"><a href="../../projekt/games.php">Available games</a></li>
        <li role="presentation"><a href="../../projekt/mygames.php">My games</a></li>
        <li role="presentation"><a href="../../projekt/playedgames.php">Played games</a></li>
        <li role="presentation" class="create_game" id="<?php echo $_SESSION['id']; ?>"><a href="#">Create game</a></li>
    </ul>
    <main>
        <table id='sorted-table' class='table table-bordered'>
            <thead class='table_header'>
            <th class="col-lg-3">ID</th>
            <th class="col-lg-3">Opponent</th>
            <th class="col-lg-3">Join</th>
            <!--            <th class="col-lg-3">Recommendation</th>-->
            </thead>
            <tbody>
            <?php foreach ($games as $game) : ?>
                <?php

                $numberOfPlayers = Player::checkGamePlayers($game->id);
                $myGames = Player::findMyGames($_SESSION['id']);
                $gameMoves = Move::checkMoveExist($game->id);//echo count($myGames);

                $opponentMove = Move::findOpponentsMove($game->id, $game->player_started_id);
                $opponent = Player::findById($opponentMove->player_id);
                $opponentUser = User::findById($opponent->user_id);

                if ((count($numberOfPlayers) < 2) && ($game->player_started_id != $_SESSION['id']) && (count($gameMoves)) > 0) {

                    $recommendationData = array();

                    $currentUser = User::findById($_SESSION['id']);
                    $playerData = Player::getPlayerRecommendationData($currentUser->id);
                    array_push($playerData, $currentUser->level);
                    $recommendationData[$_SESSION['id']] = $playerData;

                    $opponentData = Player::getPlayerRecommendationData($opponentUser->id);

                    array_push($opponentData, $opponentUser->level);
                    $recommendationData[$opponentUser->id] = $opponentData;

                    $cosineSim = Player::similarity($playerData, $opponentData);

                    if (($cosineSim > 0.5) || ($currentUser->level < 3)) {
                        ?>
                        <tr id="<?php echo $game->id ?>">
                            <td><?php echo $game->id ?></td>
                            <td><?php echo $opponentUser->login ?></td>
                            <td data-target="join_game" class="text-center">
                                <button id="<?php echo $game->player_started_id ?>" class="btn btn-primary join_game">
                                    join
                                </button>
                            </td>
                            <!--                            <td>-->
                            <?php //echo $cosineSim . " : " . $_SESSION['id'] . "-" . $opponent->user_id ?><!--</td>-->
                        </tr>
                    <?php } ?>
                <?php } ?>
            <?php endforeach; ?>
            </tbody>
        </table>
    </main>
</div>
<?php include('../projekt/includes/multiplayer_modal.php') ?>
</body>
</html>