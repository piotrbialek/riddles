$(document).ready(function () {

    $(document).on('click', 'a[data-role=update]', function () {

        var riddleId = $(this).data('id');
        var category = $('#' + riddleId).children('td[data-target=category]').text();
        var description = $('#' + riddleId).children('td[data-target=description]').text();
        var riddle = $('#' + riddleId).children('td[data-target=riddle]').text();
        var riddleLevel = $('#' + riddleId).children('td[data-target=riddleLevel]').text();


        $('#categoryModal').val(category);
        $('#descriptionModal').val(description);
        $('#riddleModal').val(riddle);
        $('#riddleLevelModal').val(riddleLevel);
        $('#riddleIdModal').val(riddleId);
        $('#myModal').modal('toggle');

    });

    $('#save').click(function () {
        var riddleId = $('#riddleIdModal').val();
        var category = $('#categoryModal').val();
        var description = $('#descriptionModal').val();
        var riddle = $('#riddleModal').val();
        var riddleLevel = $('#riddleLevelModal').val();
        var el = $('#' + riddleId).children('td');


        $.ajax({
            url: '../../projekt/ajax/edit.php',
            method: 'post',
            data: {category: category, description: description, riddle: riddle, riddleLevel: riddleLevel, riddleId: riddleId},
            success: function (response) {

                if (response == 1) {
                    // now update user record in table
                    $('#' + riddleId).children('td[data-target=category]').text(category);
                    $('#' + riddleId).children('td[data-target=description]').text(description);
                    $('#' + riddleId).children('td[data-target=riddle]').text(riddle);
                    $('#' + riddleId).children('td[data-target=riddleLevel]').text(riddleLevel);
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