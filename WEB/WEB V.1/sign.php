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
    <meta name="description" content="">
    <meta name="author" content="">
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
                    <li><a href="seconecter.php" data-target="#page-slider" data-slide-to="1">Connexion</a></li>  
                    <li class="active"><a href="#" data-target="#page-slider" data-slide-to="2">S'inscrire</a></li>                  
                </ul>
            </div>
        </div>
    </div>
</div><!--/#navigation-->

<section id="welcome-page">

    <div class="container">
		<div class="row clearfix">
			<div class="col-md-12 column">
				<div class="row clearfix">
			
			
			
	<form id="form" class="form-horizontal" method="post" action="inscri_valide.php" onsubmit="return verifForm(this);">
	
	
            <div class="col-md-3 column">	<!-- LES DONNEES PERSONNEL -->
			
				<div class="text-center">
					<button type="button" onclick="done();" class="btn btn-primary">Données personnel</button>
				</div>	
				
				<span id="info" style="display : none;" >
		
			
			
                <div class="form-group"><br>
                    <label for="InputName">Entre ton Sex</label>
                    <div class="radio" >
                    <label>
                        <input type="radio" name="sexe" id="male" value="homme" onclick="mec();" required="required"><span class="fa fa-male"></span> Male
                    </label>
                    <label>
                        <input type="radio" name="sexe" id="female2" value="femme" onclick="meuf();"> <span class="fa fa-female"></span>Female
                    </label><br />
					
					<span id="femme" style="display : none;" >
							<br />
						<div class="form-group">
							<label for="sel1">Protection</label>
							<select name="protection" class="form-control" id="select" onchange="critere1();">
							
								<option selected="selected">Sur demande</option><option>Ouvert sur critère</option><option>Ouvert à tous</option>
								
							</select>
						</div>	
						
							
					</span>
					
					<span id="critere" style="display : none;" >
						
						<div class="form-group">
						<label>Ouvert à :</label><br />
						<input type="checkbox" name="choix1" id="check_dep" onclick="crit_dep()" value="1"> Ceux de mon departement <br />
						<input type="checkbox" name="choix2" id="check_origine" onclick="crit_origine()" value="2"> Ceux de mon origine<br />
						<input type="checkbox" name="choix3" id="check_age" onclick="crit_age()" value="3">Age
						</div>
					<span id="verif_checkbox" style="display : none;" >Vous devez cocher au moins une case</span>
					</span>
						
					<span id="critere_age" style="display : none;" >
					
					 <div class="container">
		<div class="row clearfix">
	
			<div class="col-md-1 column">
							
							<div class="form-group">
							
							<label for="sel1">Age Min</label>
							 <select name="age_min" class="form-control" id="age_min" >
                        
						<option>-18</option><option>18</option><option>19</option>
						<option>20</option><option>21</option><option>22</option>
						<option>23</option><option>24</option><option>25</option>
						<option>26</option><option>27</option><option>28</option>
						<option>29</option><option>30</option><option>+30</option>
							</select>
							</div>
			
			</div>
				<div class="col-md-1 column">
							
							
							<div class="form-group">
							<label for="sel1">Age Max</label>
							 <select onclick="verif_age()" name="age_max" class="form-control" id="age_max">
                      
						<option>-18</option><option>18</option><option>19</option>
						<option>20</option><option>21</option><option>22</option>
						<option>23</option><option>24</option><option>25</option>
						<option>26</option><option>27</option><option>28</option>
						<option>29</option><option>30</option><option>+30</option>
							</select>
							</div>
							
				</div>
				</div>
				</div>
				
							
						
						</span>

                    </div>
                </div>
               
					<div class="form-group">
                      <label for="sel1">Departement</label>
                      <select name="departement" class="form-control" id="sel1" required="required">
                        <option value="">Entre ton departement</option>
						<option>Essonne</option><option>Hauts-de-Seine</option><option>Paris</option>
						<option>Seine-et-Marne</option><option>Seine-Saint-Denis</option><option>Val-d'oise</option>
						<option>Val-de-Marne</option><option>Yvelines</option>
                      </select>
                    </div>
					
                    <div class="form-group">
                      <label for="sel1">Age</label>
                      <select name="age" class="form-control" id="sel1" required="required">
                        <option value="">Entre ton Age</option>
						<option>-18</option><option>18</option><option>19</option>
						<option>20</option><option>21</option><option>22</option>
						<option>23</option><option>24</option><option>25</option>
						<option>26</option><option>27</option><option>28</option>
						<option>29</option><option>30</option><option>+30</option>
                      </select>
                    </div>
               
			   
                    <div class="form-group">
                      <label for="sel1">Origine</label>
                      <select name="origine" class="form-control" id="sel1" required="required">
                        <option value="">Entre ton Origine</option>
						<option>Afrique Subsaharienne</option>
						<option>Amerique Du Nord</option>
						<option>Amerique Latine</option>
						<option>Asie</option>
						<option>Dom-Tom</option>
						<option>Europe</option>
						<option>Europe de l'Est</option>
						<option>Maghreb</option>
						<option>Moyen-Orient</option>
						<option>Oceanie</option>
				   </select>
                    </div>
			
		
		</span>	
            </div>
			
            <div class="col-md-1 column">
			</div>
			
		
            <div class="col-md-3 column">	<!-- LES RESEAUX SOCIAUX -->
				
				
				<div class="text-center">
					<button type="button" onclick="social();" class="btn btn-primary">Reseaux Sociaux</button>
				</div>	
			
				<span id="social" style="display : none;" >
            
                
                 
                <div class="form-group"><br>
                    <label for="InputName">Facebook</label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="fb" id="facebook" placeholder="Entre ton Facebook">
                        <span class="input-group-addon"><span class="fa fa-facebook"></span></span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="InputName">Instagram</label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="insta" id="insta" placeholder="Entre ton Instagram">
                        <span class="input-group-addon"><span class="fa fa-camera-retro"></span></span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="InputName">Snapchat</label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="snap" id="snap" placeholder="Entre ton Snapchat">
                        <span class="input-group-addon"><span class="fa fa-camera"></span></span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="InputName">Twitter</label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="twitter" id="twitter" placeholder="Entre ton Twitter">
                        <span class="input-group-addon"><span class="fa fa-twitter"></span></span>
                    </div>
					<span id="reseaux" style="display : none;" >Renseigner au moins Deux reseaux</span>
                </div> 
				
				
			</span><br /><br /><br />
  			
					
					<center><input type="submit" name="submit" id="submit" value="Submit" class="btn btn-success btn-lg btn-block"></center>
			
            </div>
			
			<div class="col-md-1 column">
			</div>
			
		
            <div class="col-md-3 column"> <!-- L'ENREGISTREMENT -->
			
					<div class="text-center">
					<button type="button" onclick="register();" class="btn btn-primary">Enregistrement</button>
				</div>	
			
				<span id="register" style="display : none;" >
				
				<div class="form-group"><br>
                    <label for="InputName">Prénom</label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="nom" id="InputName" placeholder="Entre ton Prénom" required="">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>
                    </div>
                </div>
				
				 <div class="form-group">
                    <label for="InputEmail">Email</label>
                    <div class="input-group">
                        <input type="email" class="form-control" id="InputEmail" name="email" placeholder="Entre ton Email" onblur="check()" required="">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>
                    </div>
                    <span id="mail_hidden" style="display : none;" >Cet email existe déja</span>
                    <span id="email_hidden2" style="display : none;" >Email Validé</span>
                </div>
				
				 <div class="form-group">
                    <label for="Inputpassword">Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="InputPassword" name="mdp" placeholder="Enter Password" onblur="save()"required="">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>
                    </div>
                </div>
				
				 <div class="form-group">
                    <label for="Inputpassword">Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="InputPassword2" name="mdp2" placeholder="Retype Password" onchange="compare()" required="">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>
                    </div>
					 <span id="pass_hidden" style="display : none;" >Mot de pass différents</span>
                </div>
			
				<div class="form-group">
					<br />
					<input type="checkbox" name="choix1" value="1" required=""> en cochant vous accepté les 
					<a data-toggle="modal" href="CGU.html" data-target="#infos" >Conditions Générales d'utilisation </a><br />
				</div>
			</span>	
			</div>
		
	</form>
			
			<!-- modal CGU -->
		<div class="modal fade" id="infos">
			<div class="modal-dialog">  
				<div class="modal-content"></div>  
			</div> 
		</div>
			<!-- modal CGU -->
			
				</div>
            </div>
        </div>
    </div>

            
</section>     <br /><br />               
    
    
<footer id="footer" class="container">
    <nav class="navbar navbar-fixed-bottom">
        <div class="navbar-inner navbar-content-center">
           <div class="text-center"><p>Copyright © 2023 Fooye Indus. All rights reserved.</p></div>
        </div>
    </nav>
</footer>

<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>  
<script type="text/javascript" src="js/main.js"></script>

<script langage="javascript">
<!--


	function check(){
	
		var email = document.getElementById("InputEmail");
		var params = "email="+ email.value;
		
		var http = new XMLHttpRequest();
		http.open("POST", "info.php", true);
		http.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		http.onreadystatechange=function(){
			if (this.readyState==4 && this.status==200) {
				var text = parseInt(this.responseText);
				
				if(text==0){
					document.getElementById("email_hidden2").style.display = "inline";
					document.getElementById("email_hidden2").style.color = "#5DB975";
					document.getElementById("email_hidden2").style.fontWeight = "bold";
					document.getElementById("mail_hidden").style.display = "none";
					
				}else if (text == -1){
					document.getElementById("mail_hidden").style.display = "none";
					document.getElementById("email_hidden2").style.display = "none";
					
				}else if( text == 1){
					document.getElementById("mail_hidden").style.display = "inline";
					document.getElementById("mail_hidden").style.color = "red";
					document.getElementById("mail_hidden").style.fontWeight = "bold";
					document.getElementById("email_hidden2").style.display = "none";

				}else{
					
				}
			}
		};
		http.send(params);
	}
	
	
	var saved_pass;
	
	function save(){
	
		saved_pass = document.getElementById("InputPassword").value;
		
	}
	
	function compare(){
	
		var pass2 = document.getElementById("InputPassword2").value;
		
		if(saved_pass != pass2){
		
			document.getElementById("pass_hidden").style.display = "inline";
			document.getElementById("pass_hidden").style.color = "red";
			document.getElementById("pass_hidden").style.fontWeight = "bold";
			
		}else if(saved_pass == pass2)
			document.getElementById("pass_hidden").style.display = "none";
		else
			document.getElementById("pass_hidden").style.display = "none";
	}
	
	
	function verifForm(f){
		// VERIF reseaux
		var fb = document.getElementById("facebook").value;
		var insta = document.getElementById("insta").value;
		var snap = document.getElementById("snap").value;
		var twitter = document.getElementById("twitter").value;
		
		if((!fb && !insta && !snap) || (!twitter && !fb && !insta) || (!twitter && !fb && !snap) || (!twitter && !insta && !snap)){
			
			document.getElementById("verif_checkbox").style.display = "none";
			document.getElementById("reseaux").style.display = "inline";
			document.getElementById("reseaux").style.color = "red";
			document.getElementById("reseaux").style.fontWeight = "bold";
			return false;
		}
		else{
			document.getElementById("reseaux").style.display = "none";
		
					//verif femme chek critere
			var femme = document.getElementById("female2").checked;
			if(femme == true){
				var critere = document.getElementById("select").value;
				if(critere == 'Ouvert sur critère'){
					var dep = document.getElementById("check_dep").checked;
					var origine = document.getElementById("check_origine").checked;
					var age = document.getElementById("check_age").checked;
					if (!dep && !origine && !age){
						document.getElementById("verif_checkbox").style.display = "inline";
						document.getElementById("verif_checkbox").style.color = "red";
						document.getElementById("verif_checkbox").style.fontWeight = "bold";
						return false;
					}
				} 
			} 
		}
		
	}
	
	function meuf(){
		
			document.getElementById("femme").style.display = "inline";	
	}
	
	function mec(){
		
			document.getElementById("femme").style.display = "none";
			document.getElementById("select").value = 'Sur demande';
			document.getElementById("critere").style.display = "none";
			document.getElementById("critere_age").style.display = "none";
		}
	
	function critere1(){
	
			var critere = document.getElementById("select").value;
			if(critere == 'Ouvert sur critère'){
				document.getElementById("critere").style.display = "inline";	
				document.getElementById("check_age").checked = false;
			}
			else{
				document.getElementById("critere").style.display = "none";
				document.getElementById("critere_age").style.display = "none";
				document.getElementById("verif_checkbox").style.display = "none";
			}
	}
	
	function crit_age(){
		var age = document.getElementById("check_age").checked;
		if(age == true){
		document.getElementById("critere_age").style.display = "inline";
		document.getElementById("verif_checkbox").style.display = "none";
		}
		else
		document.getElementById("critere_age").style.display = "none";
	
	}
	function crit_origine(){
		var origine = document.getElementById("check_origine").checked;
		if(origine == true)	document.getElementById("verif_checkbox").style.display = "none";
	}	
	function crit_dep(){
		var dep = document.getElementById("check_dep").checked;
		if(dep == true)	document.getElementById("verif_checkbox").style.display = "none";
	}
	
	function verif_age(){
		var age_max = document.getElementById("age_max").value;
		document.getElementById('age_min').innerHTML = '<option>-18</option>';
		for(var i=18;i<age_max;i++){
			document.getElementById('age_min').innerHTML += '<option>'+i+'</option>';
		}
	}
	
	function done(){
	
		if(document.getElementById("info").style.display == "inline"){
			document.getElementById("info").style.display = "none";
		}
		
		else{
			document.getElementById("info").style.display = "inline";
		}
	}

	function register(){
	
		if(document.getElementById("register").style.display == "inline"){
			document.getElementById("register").style.display = "none";
		}
		
		else{
			document.getElementById("register").style.display = "inline";
		}
	}

	function social(){
	
		if(document.getElementById("social").style.display == "inline"){
			document.getElementById("social").style.display = "none";
		}
		
		else{
			document.getElementById("social").style.display = "inline";
		}
	}
	
// -->

</script>

</body>
</html>