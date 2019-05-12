let level_increased = false; // in case of double increase of the level

function increaseLevel() {
    let lvl_completed = true;
    document.getElementById("status").innerHTML = "processing...";

    $.ajax({
        url: '../../projekt/ajax/increaseLevel.php',
        type: 'POST',
        data: {levelCompleted: lvl_completed},
        success: function (response) {
            level_increased = true;
            document.getElementById("status").innerHTML = response;
        }
    });
}