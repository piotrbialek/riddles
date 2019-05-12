$(document).on('click', '.join_game', function () {
    let el = this;
    let initiator_id = el.id;
    let game_id = (el.parentNode.parentNode).id;
    let row = $(el).closest('tr');
    let player_id = -1;

    $.ajax({
        url: '../../projekt/ajax/joinGame.php',
        type: 'POST',
        data: {initiator_id: initiator_id, game_id: game_id},
        success: function (response) {
            if (response > 0) {
                $('#myModal').modal('show');
                player_id = response;
            } else if (response == 0) {
                $('.form-control').val('');
                $('#myModal').modal('hide');
                alert("You can not join the game. Someone has already joined this game.");
                row.addClass("red");
                row.fadeOut(800, function () {
                    $(this).remove();
                });
            } else {
                alert('Problem: ' + response);
            }
        }
    });

    var riddle_created = false;

    var loaded = false;
    $('#save').click(function () {

        var category = $('#categoryModal').val();
        var description = $('#descriptionModal').val();
        var riddle = $('#riddleModal').val();
        var riddle_level = $('#riddle_levelModal').val();

        if (loaded) return;

        $.ajax({
            url: '../../projekt/ajax/createRiddle.php',
            method: 'post',
            data: {
                category: category,
                description: description,
                riddle: riddle,
                riddle_level: riddle_level,
                accepted: 0,
                game_id: game_id
            },
            success: function (response1) {

                loaded = true;
                if (response1 == 1) {
                    $('.form-control').val('');
                    riddle_created = true;
                    player_id = -1;
                    $('#myModal').modal('hide');
                    row.addClass("green");
                    row.fadeOut(800, function () {
                        $(this).remove();
                    });
                } else {
                    alert('Problem: ' + response1);
                    loaded = false;
                }

            }
        });
    });

    var player_deleted = false;

    if (riddle_created) {
        return;
    } else {
        $("#myModal").on("hidden.bs.modal", function () {

            loaded = true;

            if (player_deleted) return;
            $.ajax({
                url: '../../projekt/ajax/deletePlayer.php',
                type: 'POST',
                data: {player_id: player_id},
                success: function (response) {
                    player_deleted = true;

                    if (!((response == 1) || (response == -1))) {
                        alert('Problem: ' + response);
                    }
                }
            });
        });
    }
});


