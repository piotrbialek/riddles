$(document).on('click', '.join_game', function () {
    let el = this;
    let player_id = el.id;
    let game_id = (el.parentNode.parentNode).id;
    let row = $(el).closest('tr');

    $('#myModal').modal('show');

    var loaded = false;
    $('#save').click(function () {
        var category = $('#categoryModal').val();
        var description = $('#descriptionModal').val();
        var riddle = $('#riddleModal').val();
        var riddle_level = $('#riddle_levelModal').val();

        if (loaded) return;
        $.ajax({
            url: '../../projekt/ajax/create_riddle.php',
            method: 'post',
            data: {
                category: category,
                description: description,
                riddle: riddle,
                riddle_level: riddle_level,
                author_id: player_id,
                accepted: 0,
                game_id: game_id
            },
            success: function (response) {

                if (response == 1) {

                    $.ajax({
                        url: '../../projekt/ajax/join_game.php',
                        type: 'POST',
                        data: {player_id: player_id, game_id: game_id},
                        success: function (response) {
                            if (response == 1) {
                                $('.form-control').val('');
                                $('#myModal').modal('hide');
                                row.addClass("green");
                                row.fadeOut(800, function () {
                                    $(this).remove();
                                });
                            } else {
                                alert('Problem: ' + response);
                            }
                        }
                    });
                }
                else {
                    alert('Problem: '+response);
                }
            }
        });
        loaded = true;

    });
});

