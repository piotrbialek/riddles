$(document).on('click', '.play_game', function () {
    let el = this;
    let game_id = (el.parentNode.parentNode).id;

    $.ajax({
        url: '../../projekt/ajax/playGame.php',
        type: 'POST',
        data: {game_id: game_id},
        success: function (response) {
            if (response > 0) {
                var url = '../projekt/multiplayer.php';
                var form = $('<form action="' + url + '" method="post">' +
                    '<input type="text" name="riddle_id" value="' + response + '" />' +
                    '</form>');
                $('body').append(form);
                form.submit();
            } else {
                alert('Problem: ' + response);
            }
        }
    });
});