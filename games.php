<?php
session_start();

include("../projekt/notLoggedRedirect.php");
include_once("admin/includes/Game.php");
include_once("admin/includes/Player.php");
include_once("admin/includes/Move.php");

$games = Game::findAll();


?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
    <?php include('includes/base_head.php') ?>
    <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
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

    <main>
        <div class="subtitle text-center">Available Games</div>
        <button class="create_game" id="<?php echo $_SESSION['id']; ?>">create game</button>
        <button onclick="window.location.href='../../projekt/mygames.php';">my games</button>
        <button onclick="window.location.href='../../projekt/playedgames.php';">played games</button>
        <table id='sorted-table' class='table table-bordered'>
            <thead class='table_header'>
            <th>Id</th>
            <th class="col-lg-2">user_id</th>
            <th class="col-lg-2">join</th>
            </thead>
            <tbody>
            <?php foreach ($games as $game) : ?>
                <?php

                $numberOfPlayers = Player::checkGamePlayers($game->id);
                $myGames = Player::findMyGames($_SESSION['id']);
                $gameMoves = Move::checkMoveExist($game->id);

                if ((count($numberOfPlayers) < 2) && ($game->player_started_id != $_SESSION['id']) && (count($gameMoves)) > 0) {
                    ?>
                    <tr id="<?php echo $game->id ?>">
                        <td><?php echo $game->id ?></td>
                        <td><?php echo $game->player_started_id ?></td>
                        <td data-target="join_game" class="text-center">
                            <button id="<?php echo $game->player_started_id ?>" class="join_game">join</button>
                        </td>
                    </tr>
                <?php } ?>
            <?php endforeach; ?>
            </tbody>
        </table>


    </main>

</div>
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Create riddle</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="categoryModal">Category (3-20 characters)</label>
                    <input type="text" id="categoryModal" class="form-control">
                </div>

                <div class="form-group">
                    <label for="descriptionModal">Description (3-60 characters)</label>
                    <input type="text" id="descriptionModal" class="form-control">
                </div>

                <div class="form-group">
                    <label for="riddleModal">Riddle (3-60 characters)</label>
                    <input type="text" id="riddleModal" class="form-control">
                </div>

                <div class="form-group">
                    <label for="riddle_levelModal">Level (1-100)</label>
                    <input type="number" id="riddle_levelModal" class="form-control">
                </div>
                <input type="hidden" id="riddle_idModal" class="form-control">
            </div>
            <div class="modal-footer">
                <a href="javascript:;" id="save" class="btn btn-primary pull-right">Create</a>
            </div>
        </div>

    </div>
</div>

</body>
</html>