// let levelIncreased=false; // in case of double increase of the level

function sendRiddleResult(result) {

    let userResult=result;

    document.getElementById("status").innerHTML = "processing...";

    $.ajax({
        url: '../../projekt/ajax/riddleCompleted.php',
        type: 'POST',
        data: {riddleId: riddleId, userResult: userResult},
        success: function (response) {
            // levelIncreased=true;

            alert(response);
            document.getElementById("status").innerHTML = response;
        }
    });
}