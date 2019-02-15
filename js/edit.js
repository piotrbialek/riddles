$(document).ready(function () {

    $('.edit').click(function () {

        var riddleId = this.id;
        var category = $('#' + riddleId).children('td[data-target=category]').text();
        var description = $('#' + riddleId).children('td[data-target=description]').text();
        var riddle = $('#' + riddleId).children('td[data-target=riddle]').text();
        var riddle_level = $('#' + riddleId).children('td[data-target=riddle_level]').text();

        $('#categoryModal').val(category);
        $('#descriptionModal').val(description);
        $('#riddleModal').val(riddle);
        $('#riddle_levelModal').val(riddle_level);
        $('#riddleIdModal').val(riddleId);
        $('#myModal').modal('toggle');

    });

    $(document).keypress(function (e) {
        if (e.which === 13) {

        }
    });

    $('#save').click(function () {
        var riddleId = $('#riddleIdModal').val();
        var category = $('#categoryModal').val();
        var description = $('#descriptionModal').val();
        var riddle = $('#riddleModal').val();
        var riddle_level = $('#riddle_levelModal').val();
        var el = $('#' + riddleId).children('td');


        $.ajax({
            url: '../../projekt/ajax/edit.php',
            method: 'post',
            data: {
                category: category,
                description: description,
                riddle: riddle,
                riddle_level: riddle_level,
                riddleId: riddleId
            },
            success: function (response) {

                if (response == 1) {

                    $('#' + riddleId).children('td[data-target=category]').text(category);
                    $('#' + riddleId).children('td[data-target=description]').text(description);
                    $('#' + riddleId).children('td[data-target=riddle]').text(riddle);
                    $('#' + riddleId).children('td[data-target=riddle_level]').text(riddle_level);
                    $('#myModal').modal('toggle');

                    $(el).closest('tr').fadeOut(250).fadeIn(250);

                    $('#' + riddleId).addClass("green");
                    setTimeout(function () {
                        $('#' + riddleId).removeClass("green").fadeIn("slow");
                    }, 800);
                } else {
                    alert('The data entered is not correct');
                }
            }
        });
    });
});