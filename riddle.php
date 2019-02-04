<?php
	include('getData.php');
?>
<script type="text/javascript">
  var category = '<?php echo $category ;?>';
  var description = <?php echo json_encode($description); ?>;
  var riddle = <?php echo json_encode($riddle); ?>;
  var level = <?php echo json_encode($current_level); ?>;  
</script>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script> 
    <script src="js/skryptRiddle.js"></script>
    <script src="js/typed.js" type="text/javascript"></script>
	<title>Riddles</title>
	<link rel="stylesheet" href="css/main.css" type="text/css" />
    <link rel="stylesheet" href="css/bootstrap.css" type="text/css">
</head>  
<body>
    

	<div class="container">
			<?php include('includes/title.php') ?>
						<?php
					if (isset($_SESSION['blad']))
					{
						echo $_SESSION['blad'];
						//unset($_SESSION['blad']);
					}?>
		
            
            <div class="row">
			<?php
					if (isset($_SESSION['info_level']))
					{
						echo $_SESSION['info_level'];
						unset($_SESSION['info_level']);
					}?>
				<div class="category text-center" id="category"></div>
            </div>
            
            <div class="row text-center">    
                <div id="description"></div>
            </div>
			
            
            <div class="row">
				<div id="organize" class="not_display">
                    <div class="col-xs-4">

							<input class="pull-right" id="input" autofocus/>
						
                    </div>
                    <div class="col-xs-8 guessesBox">
                        <span class="glyphicon glyphicon-ok green" style="font-size:120%"></span>
                        <span class="green guesses" id="rightGuesses"></span><br>
                        <span class="glyphicon glyphicon-remove red" style="font-size:120%"></span>
                        <span class="red guesses" id="wrongGuesses"></span>
                    </div>
			     
				</div>
                
            </div>
            
			<div class="text-center" id="info"> </div>
            <div id="buttons" class="text-center not_display">
			    <input type=button class="btn btn-primary button" id="buttonPlay"/>
                <div id="status"></div>
            </div>
            
            <div class="row">
                <div class="col-lg-1 col-md-1"></div>
<!--                <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 text-center" id="sentence"></div>-->
                <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12" id="sentence"></div>
                <div class="col-lg-5 col-md-5" id="image">
                    <img id="imageImg" src="image/transparent/wisielec0.png" class="img-responsive">
                </div>
                <div class="col-lg-1 col-md-1"></div>
			</div>	
	</div>
</body>
</html>