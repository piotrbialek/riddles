$(document).on('click', '.create_game', function () {
    $('.form-control').val('');
    let el = this;
    var user_id = el.id;
    let parent = el.parentNode;
    let game_id;
    let create = true;
    $('#myModal').modal('show');

    var loaded = false;
    var loaded2 = false;

    // $('#myModal').modal({
    //     backdrop: 'static',
    //     keyboard: false
    // });

    $("#myModal").on("hidden.bs.modal", function () {
        loaded=true;
        loaded2=true;
    });
    // $('#save').click(function () {
    $('#save').on('click',function () {

        var category = $('#categoryModal').val();
        var description = $('#descriptionModal').val();
        var riddle = $('#riddleModal').val();
        var riddle_level = $('#riddle_levelModal').val();


        if (loaded) return;
        // if (loaded2) return;
        $.ajax({
            url: '../../projekt/ajax/create_game.php',
            type: 'POST',
            data: {create: create},
            success: function (response) {
                loaded = true;
                if (response > 0) {
                    game_id = response;
                    if (loaded2) return;

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
                                loaded=true;
                                // loaded2 = true;
                            } else {
                                alert('Problem: ' + response);
                                // loaded2 = false;
                                loaded=false;
                            }
                        }
                    });

                } else {
                    alert('Problem: ' + response);
                }
            }
        });
    });

});