let levelIncreased=false; // in case of double increase of the level

function increaseLevel() {

    let lvlCompleted = true;

    document.getElementById("status").innerHTML = "processing...";

    $.ajax({
        url: '../../projekt/ajax/increaseLevel.php',
        type: 'POST',
        data: {levelCompleted: lvlCompleted},
        success: function (response) {
            levelIncreased=true;
            document.getElementById("status").innerHTML = response;
        }
    });
}