window.onload = start;

var wrongAttempts = 0;
var wrongGuesses = "";
var rightGuesses = "";
var levelCompleted = false;
var temporarySentence = "";
var displayedSentence = "";

riddle = riddle.toUpperCase();
description = description.toUpperCase();
category = category.toUpperCase();

function drawLines() {
    for (let i = 0; i < riddle.length; i++) {
        if (riddle.charAt(i) === " ") {
            temporarySentence = temporarySentence + " ";
        }
        else {
            temporarySentence = temporarySentence + "_";
        }
    }
    displayedSentence = temporarySentence;
    showSentence();
}

function showSentence() {
    $("#sentence").html(displayedSentence);
}


String.prototype.setLetter = function (place, sign) {
    if (place > this.length - 1) return this.toString();
    else return this.substr(0, place) + sign + this.substr(place + 1);
}


function gameWon(result) {

    $(document).keypress(function (e) {
        if (e.which === 13) {
            window.location.href = "game.php";
        }
    });

    $("#buttonPlay").bind("click", function () {
        window.location.href = "game.php";
    });

    $("#organize").fadeOut("slow", function () {
        $("#image").fadeOut("fast");
        $("#sentence").fadeOut();
        $("#info").fadeIn("slow");

        let info;


        if (result) {
            info = "<b>Congratulations!</b><br>Riddle correct:<br>" + riddle;
        }
        else {
            info = "Unfortunately, not this time!";
        }

        var typed3 = new Typed("#info", {
            strings: ["", info, "Click button or press enter to continue."],
            startDelay: 100,
            typeSpeed: 20,
            backSpeed: 10,
            loop: false,
            onComplete: function (self) {
                $("#buttons").removeClass("not_display");
                $("#buttonPlay").fadeIn("slow");
            }
        });
    });
}

function checkWin() {
    if (riddle === temporarySentence) {
        $("#image").fadeOut("slow", function () {
            $("#organize").fadeOut();
            $("#sentence").fadeOut();
            $("#info").fadeIn("slow");
            $("#buttonPlay").hide();

            levelCompleted = true;
            increaseLevel();
            $("#buttonPlay").val("Next level");

            gameWon(true);

        });
    }
    else if (wrongAttempts > 2) {

        $("#input").off("keyup");
        $("#buttonPlay").val("Try again");
        gameWon(false);
    }
}

function checkLetterInSentence(inputLetter) {
    let correctLetter = 0;

    for (let i = 0; i < riddle.length; i++) {
        let sentenceLetter = riddle.charAt(i);

        if (sentenceLetter === inputLetter) {
            temporarySentence = temporarySentence.setLetter(i, inputLetter);
            displayedSentence = temporarySentence;
            displayedSentence = displayedSentence.replace(
                new RegExp(sentenceLetter, "g"),
                '<span class="l green hideLetter correctLetter">' + sentenceLetter + '</span>'
            );
            setTimeout(function () {
                $(".l").fadeOut("fast", function () {
                    $(".l").removeClass("hideLetter").fadeIn("fast");
                });
            }, 100);
            correctLetter++;
        }
    }


    if (correctLetter > 0) {
        rightGuesses += inputLetter + " ";
        $("#rightGuesses").text(rightGuesses);
        $("#sentence").removeClass("red");
        $("#sentence").addClass("gray");
        showSentence();

        $("#input").addClass("greenBlink");
        setTimeout(function () {
            $("#input").removeClass("greenBlink").fadeIn("slow");
        }, 200);
    }
    else {
        wrongGuesses += inputLetter + " ";
        $("#wrongGuesses").text(wrongGuesses);
        $(".correctLetter").removeClass("green");
        $("#sentence").removeClass("gray");
        $("#sentence").addClass("red");

        $("#input").addClass("redBlink");
        setTimeout(function () {
            $("#input").removeClass("redBlink").fadeIn("slow");
        }, 200);

        wrongAttempts++;
        let img = "image/szubienica_img/img" + wrongAttempts + ".png";
        $("#image").fadeOut("fast", function () {
            $("#image").html('<img src="' + img + '" alt="hangerMan' + wrongAttempts + '" />');
            $("#image").fadeIn();
        });
    }


//        if(correctLetter>0)
//        {
//                $('#input').val('');
//                rightGuesses+=letter+" ";
//                $('#rightGuesses').html(rightGuesses);
//                $('#sentence').addClass('green');
//                write();
//                guesses+=letter;
//        }
//        else
//        {
//            if(inGuesses==0)
//            //if(checkGuesses(letter))
//            {
//                $('#input').val('');
//                wrongGuesses+=letter+" ";
//                $('#wrongGuesses').html(wrongGuesses);
//                $('#sentence').addClass('red');
//                guesses+=letter;
//                gLength=guesses.length;
//                count++;
//                let img = "image/szubienica_img/img"+count+".png";
//                $('#image').fadeOut('fast', function() {
//                    $("#image").html('<img src="'+img+'" alt="hangerMan'+count+'" />');
//                    $("#image").fadeIn();
//                });
//            }
//        }
}

// checks if this particular letter has already been entered
function checkGuesses(letter) {
    let inGuesses = 0;
    let guesses = rightGuesses.concat(wrongGuesses);
    for (let i = 0; i < guesses.length; i++) {
        if (guesses.charAt(i) === letter) {
            inGuesses++;
        }
    }
    return inGuesses;
}

function checkLetter() {

    let inputField = $("#input");
    if (inputField.val() === " " || inputField.val().length > 1 || !isNaN(inputField.val())) // || $("#input").val() == "undefined"
    {
        $("#info").text("incorrect input");
        $("#input").val("");

        $("#input").addClass("blueBlink");
        setTimeout(function () {
            $("#input").removeClass("blueBlink").fadeIn("slow");
        }, 200);
    }
    else {
        let inputLetter = inputField.val().toUpperCase();

        $("#info").text("");
        inputField.val("");


        if (checkGuesses(inputLetter) === 0) {
            checkLetterInSentence(inputLetter);
        }
        else {
            $("#info").html("repeated letter " + inputLetter);
            $("#sentence").addClass("gray");
        }
        checkWin();
    }
}

function start() {

    $("#category, #description, #sentence, #image, #organize, #buttonNext, #buttonTryAgain").hide();

    $("#input").keypress(function (e) {
        let regex = new RegExp("^[a-zA-ZżźćńółęąśŻŹĆŃÓŁĘĄŚ]{1}");
        let str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
        if (regex.test(str)) {
            return true;
        }
        e.preventDefault();
        return false;
    });

    $("#sentence").html("");
    $("#sentence").addClass("gray");
    $("#info").text("");
    $("#rightGuesses").text(rightGuesses);
    $("#wrongGuesses").text(wrongGuesses);
    $("#input").val("");


    var typed = new Typed("#category", {
        strings: ["CATEGORY", category],
        typeSpeed: 30,
        backSpeed: 30,
        onComplete: function (self) {
            var typed2 = new Typed("#description", {
                strings: [description],
                startDelay: 1000,
                typeSpeed: 30,
                onComplete: function (self) {

                    $("#image, #organize, #sentence").fadeIn();
                    $("#input").focus();
                }

            });
        }
    });


    $("#category").fadeIn("slow");
    $("#description").fadeIn("slow");
    drawLines();

//        var img = "image/transparent/wisielec0.png";
    let img = "image/szubienica_img/img0.png";
    $("#image").html('<img src="' + img + '" alt="hangerMan" />');

    $("#input").on("keyup", function (event) {
        checkLetter();
    });


}



