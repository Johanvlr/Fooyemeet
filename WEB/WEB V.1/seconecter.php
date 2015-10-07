<?php session_start(); 
try { 
		if (isset($_SESSION['conect']) && !empty($_SESSION['conect'])){
			header("Location: index.php");
			die(); 
		}
	
		$bdd = new PDO('mysql:host=localhost;dbname=meet', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	}
	
catch(Exception $e) {

		die('Erreur : '.$e->getMessage()); 
 } 
 
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
       <meta name="description" content="connexion fooye-meet">
    <meta name="author" content="Fooye Industrie">
    <title>Fooye - Meet</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet"> 
    <link href="css/main.css" rel="stylesheet">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="style.css"/>
    <!--[if lt IE 9]>
        <script src="js/html5shiv.js"></script>
        <script src="js/respond.min.js"></script>
    <![endif]-->
    <link rel="shortcut icon" href="images/favicon.ico">

		<style type="text/css">
	
			.popup {
			position:fixed;
			left: 0;
			right: 0;
			bottom: 0;
			margin: 0px auto;
			margin-bottom: 20px;

			width: 200px;
			height: auto;
			padding: 20px;
			opacity: 0;

			text-align: center;

			box-shadow: 5px 5px 2px #888888;
			border-radius: 4px;

			color: white;
			font-weight: bold;

			-webkit-animation-duration: 4s; /* Chrome, Safari, Opera */
			animation-duration: 4s;
			-moz-transition-duration: 4s;
			-o-transition-duration: 4s;
		}
		
		@-webkit-keyframes showing {
			/*from {opacity: 0.8;}
			to {opacity: 0;}*/
			0% {
				opacity: 0;
				margin-bottom: -50px;
			}
			10% {
				opacity: 0.8;
				margin-bottom: 20px;
			}
			90% {
				opacity: 0.8;
				margin-bottom: 20px;
			}
			100% {
				opacity: 0;
				margin-bottom: -50px;
			}
		}
		@keyframes showing {
			0% {
				opacity: 0;
				margin-bottom: -50px;
			}
			10% {
				opacity: 0.8;
				margin-bottom: 20px;
			}
			90% {
				opacity: 0.8;
				margin-bottom: 20px;
			}
			100% {
				opacity: 0;
				margin-bottom: -50px;
			}
		}
	</style>
	
</head><!--/head-->

<body>

<!--.preloader-->
<div class="preloader"><i class="fa fa-circle-o-notch fa-spin"></i></div>
<!--/.preloader-->

<header id="header"> 
    <div class="container">
        <div class="container-inner">
            <div class="logo pull-left">
                <a class="pull-left logo" href="index.php">
                    <h1><img class="img-responsive" src="images/logo.png" alt="logo"></h1>
                </a>
            </div>
            <div class="menu pull-right">
                <a href="#" class="nav-button">
                    <i class="fa fa-align-justify"></i> Menu
                </a> 
            </div>
        </div>
    </div>
</header> <!--/#header-->

<div id="navigation">
    <div class="vertical-middle">
        <div class="vertical-middle-inner">
            <div class="main-nav">
                <a id="hidemenu" href="#"><i class="fa fa-times-circle fa-2x"></i></a>
                <ul>                     
                    <li><a href="index.php" data-target="#page-slider" data-slide-to="0">Home</a></li>
                    <li class="active"><a href="#" data-target="#page-slider" data-slide-to="1">Connexion</a></li>  
                    <li><a href="sign.php" data-target="#page-slider" data-slide-to="2">S'inscrire</a></li>                  
                </ul>
            </div>
        </div>
    </div>
</div><!--/#navigation-->

 <section id="welcome-page">
         <div class="container">
            <div class="row clearfix">
                <div class="col-md-12 column col-md-offset-4">
                    <div class="row clearfix">

				
			<form class="form-horizontal" method="post" action="seconecter.php">
						
				<div class="col-md-4 column">
				
						 <div class="form-group">
							<div class="input-group">
								<input type="text" class="form-control" name="email" id="InputName" placeholder="Enter Email" required="">
								<span class="input-group-addon"><span class="fa fa-user"></span></span>
							</div>
						</div>
						
						<div class="form-group">
							<div class="input-group">
								<input type="password" class="form-control" name="mdp" id="InputName" placeholder="Enter Password" required="">
								<span class="input-group-addon"><span class="fa fa-lock"></span></span>
							</div>
						</div>
						
						<div class="col-md-7 column">
							
							<input type="submit" name="submit" id="submit" value="Submit" class="btn btn-info pull-right">
							
						</div>
				</div>
				
			</form>
			<br />
			<?php
				
				
				if(isset($_POST['submit'])){
					if($_POST['submit']){
				
						$hache=sha1($_POST['mdp']);
						
						$req = $bdd->prepare('SELECT email,password FROM carte WHERE email = ? AND password = ?');
						$req->execute(array($_POST['email'], $hache));
						$exist = $req->fetch();
						
						if($exist['email'] AND $exist['password']){
						
							$_SESSION['conect']='on';
							$_SESSION['email']=$exist['email'];
							
							echo '<script language="Javascript">
							<!--
							document.location.replace("index.php");
							// -->
							</script>';
						
						}
			
						$erreur = true;
					
					}
					
				}
			
			?>
				
                <div class="col-md-1 column">
                </div>
				
						
                    </div>
                </div>
            </div>
        </div>

    
    <br><br><br><br><br>
	<div class="popup" id="toast"></div>
<footer id="footer" class="text-center">
    <center><p>Copyright © 2023 Fooye Indus. All rights reserved.</p></center>
</footer>

<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>  
<script type="text/javascript" src="js/main.js"></script>
<script langage="javascript">
<!--
var Toast = new function(){
    this.color = "red";
    this.DISPLAY_DURATION = 1500;
    this.showing = false;
    this.previous_code = 0;


    this.hide = function(){
        document.getElementById("toast").style.webkitAnimationName = "hiding";
        self.DISPLAY_DURATION = 0;
        self.showing = false;
    };

    this.show = function(message, code){
        var toast = document.getElementById("toast");

        if(code != this.previous_code){
            this.previous_code = code;
            toast.innerHTML = "";
        }
        toast.innerHTML = message;
        var color = "";
        if(code == 500){
            color = "#c0392b";
        }else if(code == 200){
            color = "#27ae60";
        }else if(code == 300){
            color = "#e67e22";
        }

        toast.className = "popup";
        toast.style.background = color;
        var self = this;
        this.showing = true;
        this.DISPLAY_DURATION += 3000;

        toast.style.webkitAnimationName = 'showing';
        toast.style.animationName = 'showing';

        if(toast.attachEvent){
            toast.attachEvent('webkitAnimationEnd', function(){
                this.style.webkitAnimationName = '';
                self.showing = false;
            }, false);

            toast.attachEvent('animationend', function(){
                this.style.animationName = '';
                self.showing = false;
            }, false);

        }else{
            toast.addEventListener('webkitAnimationEnd', function(){
                this.style.webkitAnimationName = '';
                self.showing = false;
            }, false);
            toast.addEventListener('animationend', function(){
                this.style.animationName = '';
                self.showing = false;
            }, false);
        }


    };
};
	<?php
		if(isset($erreur) && $erreur){
	?>	
		Toast.show("Identifiants incorrects ou inconnues", 500);
	<?php	
		}
	?>


//-->
</script>

</body>
</html>