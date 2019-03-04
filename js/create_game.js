$(document).on('click', '.create_game', function () {
    let el = this;
    let user_id = el.id;
    let parent = el.parentNode;
    let game_id;
    let create = true;
    $('#myModal').modal('show');


    var loaded = false;
    $('#save').click(function () {
        var category = $('#categoryModal').val();
        var description = $('#descriptionModal').val();
        var riddle = $('#riddleModal').val();
        var riddle_level = $('#riddle_levelModal').val();


        if (loaded) return;
        $.ajax({
            url: '../../projekt/ajax/create_game.php',
            type: 'POST',
            data: {create: create},
            success: function (response) {
                if (response > 0) {

                    game_id = response;

                    $.ajax({
                        url: '../../projekt/ajax/create_riddle.php',
                        method: 'post',
                        data: {
                            category: category,
                            description: description,
                            riddle: riddle,
                            riddle_level: riddle_level,
                            author_id: user_id,
                            accepted: 0,
                            game_id: game_id
                        },
                        success: function (response) {
                            if (response == 1) {
                                $('.form-control').val('');
                                $('#myModal').modal('hide');
                            } else {
                                alert('Problem: ' + response);
                            }
                        }
                    });
                } else {
                    alert('Problem: ' + response);
                }
            }
        });
        loaded = true;

    });
});
