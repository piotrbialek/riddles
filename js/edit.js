$(document).ready(function () {

    $('.edit').click(function () {

        var riddle_id = this.id;
        var category = $('#' + riddle_id).children('td[data-target=category]').text();
        var description = $('#' + riddle_id).children('td[data-target=description]').text();
        var riddle = $('#' + riddle_id).children('td[data-target=riddle]').text();
        var riddle_level = $('#' + riddle_id).children('td[data-target=riddle_level]').text();


        $('#categoryModal').val(category);
        $('#descriptionModal').val(description);
        $('#riddleModal').val(riddle);
        $('#riddle_levelModal').val(riddle_level);
        $('#riddle_idModal').val(riddle_id);
        $('#myModal').modal('toggle');

    });


    $('#save').click(function () {
        var riddle_id = $('#riddle_idModal').val();
        var category = $('#categoryModal').val();
        var description = $('#descriptionModal').val();
        var riddle = $('#riddleModal').val();
        var riddle_level = $('#riddle_levelModal').val();

        var author_name_with_id = $('#' + riddle_id).children('td[data-target=author_id]').text();

        var author_id = author_name_with_id.substring(
            author_name_with_id.lastIndexOf("(") + 1,
            author_name_with_id.lastIndexOf(")")
        );

        var accepted = $('#' + riddle_id).children('td[data-target=accepted]').attr('id');

        $.ajax({
            url: '../../projekt/ajax/edit.php',
            method: 'post',
            data: {
                category: category,
                description: description,
                riddle: riddle,
                riddle_level: riddle_level,
                riddle_id: riddle_id,
                author_id: author_id,
                accepted: accepted
            },
            success: function (response) {

                if (response == 1) {

                    $('#' + riddle_id).children('td[data-target=category]').text(category.toUpperCase());
                    $('#' + riddle_id).children('td[data-target=description]').text(description.toUpperCase());
                    $('#' + riddle_id).children('td[data-target=riddle]').text(riddle.toUpperCase());
                    $('#' + riddle_id).children('td[data-target=riddle_level]').text(riddle_level);
                    $('#myModal').modal('toggle');

                    $('#' + riddle_id).children('td').closest('tr').fadeOut(250).fadeIn(250);

                    $('#' + riddle_id).addClass("green");
                    setTimeout(function () {
                        $('#' + riddle_id).removeClass("green").fadeIn("slow");
                    }, 800);
                } else if(response == 2) {
                    alert('Record not updated');
                } else{
                    alert('The data entered is not correct');
                }
            }
        });
    });
});