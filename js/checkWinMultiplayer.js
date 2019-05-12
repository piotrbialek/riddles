function checkWin() {
    if (riddle === temporary_sentence) {
        $("#image").fadeOut("slow", function () {
            $("#organize").fadeOut();
            $("#sentence").fadeOut();
            $("#info").fadeIn("slow");
            $("#buttonPlay").hide();

            levelCompleted = true;
            let result = 1;

            sendRiddleResult(result);
            gameWonMultiplayer(true);
        });
    }
    else if (wrong_attempts > 2) {
        let result = 0;
        $("#input").off("keyup");
        sendRiddleResult(result);
        gameWonMultiplayer(false);
    }
}