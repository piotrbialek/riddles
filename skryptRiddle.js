window.onload = start;

var count;
var wrongGuesses;
var rightGuesses;
var guesses=" ";
var gLength=guesses.length;


riddle = riddle.toUpperCase();
description = description.toUpperCase();
category = category.toUpperCase();

var tempSentence = "";


function drawLine()
{
	for (i=0; i<riddle.length; i++)
	{
		if (riddle.charAt(i)==" ") 
		{
			tempSentence= tempSentence + " ";
		}
		else 
		{
			tempSentence = tempSentence + "_";
		}
	}
}

function write()
{
	$("#sentence").html(tempSentence);
    
}


String.prototype.ustawZnak = function(miejsce, znak)
{
	if (miejsce > this.length - 1) return this.toString();
	else return this.substr(0, miejsce) + znak + this.substr(miejsce+1);
}




function checkLetter()
{
	     
	
	if($('#input').val() == ' '  || $('#input').val().length>1 || !isNaN($('#input').val())) // || $('#input').val() == 'undefined'	
	{
		$("#info").text("incorrect input");
        $('#input').val('');
	}
	else
	{  
						var letter = $('#input').val().toUpperCase();
						$("#info").html(" ");

						var correctLetter = 0;
						var inGuesses = 0;						
					
						for(i=0; i<riddle.length; i++)
						{
							if (riddle.charAt(i) == letter) 
							{
								tempSentence = tempSentence.ustawZnak(i,letter);
								correctLetter=correctLetter+1;
							}

						}

						for(i=0; i<gLength; i++)
						{
							if (guesses.charAt(i) == letter) 
							{
								inGuesses++;
							}
						}
					
						if(correctLetter>0)
						{						
							if(inGuesses==0)
							{
								$('#input').val('');
								rightGuesses+=letter+" ";
								$('#rightGuesses').html(rightGuesses);
                                $('#sentence').addClass('green');
								write();
								guesses+=letter;
								gLength=guesses.length;
							}
							else 
							{
								$("#info").html('repeated letter '+letter);
								$('#input').val('');		
                                $('#sentence').addClass('gray');
							}
						}
						else
						{
							if(inGuesses==0)
							{
								$('#input').val('');
								wrongGuesses+=letter+" ";
								$('#wrongGuesses').html(wrongGuesses);
                                $('#sentence').addClass('red');
								guesses+=letter;
								gLength=guesses.length;
								count++;
                                var img = "image/szubienica_img/img"+count+".png";
                                $('#image').fadeOut('fast', function() {
                                    $("#image").html('<img src="'+img+'" alt="" />');
								    $("#image").fadeIn();
                                });
							}
							else
							{	
								$("#info").html('repeated letter '+letter);
								$('#input').val('');		
								$('#sentence').addClass('gray');
							}
						}
				
				
						if (riddle == tempSentence)
						{			
                                $('#image').fadeOut('slow', function() {
                                    $('#organize').fadeOut();
                                    $('#sentence').fadeOut();
                                    $('#info').fadeIn('slow');
                                    $("#buttonTryAgain").hide();

                                    var typed3 = new Typed("#info", {
                                    strings: ["","Congratulations!","Riddle correct:<br>"+riddle],
                                    startDelay: 500,
                                    typeSpeed: 50,
                                    backSpeed: 10,
                                    loop: false,
                                    onComplete: function(self) {

                                            $("#buttonNext").fadeIn('slow');

                                    }

								    });
                                });    
                                                     
						
						}
					
						else if (count>6)
						{

                            $("#input").off("keyup");
                           
                            $('#organize').fadeOut('slow', function() {
                                    $('#image').fadeOut('fast');
                                    $('#sentence').fadeOut();
                                    $('#info').fadeIn('slow');
                                    $("#buttonTryAgain").hide();
                                    
                                    
                                    
                                    var typed3 = new Typed("#info", {
                                    strings: ["","Unfortunately, not this time!", "You can try again"],
                                    startDelay: 500,
                                    typeSpeed: 50,
                                    backSpeed: 10,
                                    loop: false,
                                    onComplete: function(self) {


                                            $("#buttonTryAgain").fadeIn('slow');
                                            console.log('! count:'+count);

                                    }

								    });
                                });
								
	
                        }
					
	}		
}

function btnNext()
{
	window.location.href='levelUp.php';
}


function start()
{

    $('#category, #description, #sentence, #image, #organize, #buttonNext, #buttonTryAgain').hide();

	$("#buttonNext").bind("click", function() {
    btnNext();
    });
	
	$("#buttonTryAgain").bind("click", function() {
    //location.reload();
    window.location.href='riddle.php';
	});
	
	$('#input').keypress(function (e) {
		var regex = new RegExp("^[a-zA-ZżźćńółęąśŻŹĆŃÓŁĘĄŚ]{1}");
		var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
		if (regex.test(str)) {
			return true;
		}

		e.preventDefault();
		return false;
});

		$('#sentence').addClass('gray');
		count=0;
		$("#info").html(" ");
        rightGuesses=[];
        wrongGuesses=[];
		$('#rightGuesses').text(rightGuesses);
		$('#wrongGuesses').text(wrongGuesses);
		guesses='';
//        setTimeout("$('#image, #organize, #sentence').fadeIn();",2000); 
//        $('#image, #organize').show();
		$("#sentence").html('');
    
        
        var typed = new Typed("#category", {
            strings: ['CATEGORY',category],
            typeSpeed: 50,
            backSpeed: 50,
            onComplete: function(self) { 
                var typed2 = new Typed("#description", {
                strings: [description],
                startDelay: 1000,
                typeSpeed: 40,
                onComplete: function(self) {
                    
                    $('#image, #organize, #sentence').fadeIn();
                    $('#input').focus();
                    
                    
                }

            }); }
        }); 
    
        
        
    
        
        
		$('#category').fadeIn('slow');
		$('#description').fadeIn('slow');
		tempSentence = "";
		drawLine();
		write();
//        var img = "image/transparent/wisielec0.png";
        var img = "image/szubienica_img/img0.png";
        $("#image").html('<img src="'+img+'" alt="hangerMan" />');
		$('#input').val('');

		
	    $( "#input" ).on( "keyup", function( event ) {
  
        checkLetter();
});
    

    
	
}


    
