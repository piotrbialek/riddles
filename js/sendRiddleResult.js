let loaded=false; // in case of double increase of the level

function sendRiddleResult(result) {

    let userResult=result;

    document.getElementById("status").innerHTML = "processing...";

    if (loaded) return;
    $.ajax({
        url: '../../projekt/ajax/riddleCompleted.php',
        type: 'POST',
        data: {riddleId: riddleId, userResult: userResult},
        success: function (response) {
            document.getElementById("status").innerHTML = response;
        }
    });
    loaded=true;
}