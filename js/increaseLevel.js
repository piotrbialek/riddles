function increaseLevel() {

    let lvlCompleted = true;

    document.getElementById("status").innerHTML = "processing...";

    $.ajax({
        url: '../../projekt/ajax/increaseLevel.php',
        type: 'POST',
        data: {levelCompleted: lvlCompleted},
        success: function (response) {

            document.getElementById("status").innerHTML = response;
        }
    });
}