<?php
session_start(); // On démarre la session AVANT toute chose

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
    <link rel="stylesheet" href="css/animation.css">
    <!--[if lt IE 9]>
        <script src="js/html5shiv.js"></script>
        <script src="js/respond.min.js"></script>
    <![endif]-->
    <link rel="shortcut icon" href="images/icon.jpg">		
</head><!--/head-->



<body>

<!--.preloader-->
<div class="preloader"><i class="fa fa-circle-o-notch fa-spin"></i></div>
<!--/.preloader-->

<header id="header"> 
    <div class="container">
        <div class="container-inner">
            <div class="logo pull-left">
                <a class="pull-left logo" href="meet.php">
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
            <div class="main-nav" >
                <a id="hidemenu" href="#"><i class="fa fa-times-circle fa-2x"></i></a>
                <ul>                     
                    <li class="active"><a href="#" data-target="#page-slider" data-slide-to="0">Home</a></li>
					
					<?php 
					
				if(isset($_SESSION['conect'])){	
					if($_SESSION['conect']){	?>
					
                    <li><a href="profil.php" data-target="#page-slider" data-slide-to="1">Mon Profil</a></li>
                    <li><a href="deco.php" data-target="#page-slider" data-slide-to="2">Se Déconecter</a></li>
				<?php }
				
				}else{	?>
					
					<li><a href="seconecter.php" data-target="#page-slider" data-slide-to="1">Connexion</a></li>
                    <li><a href="sign.php" data-target="#page-slider" data-slide-to="2">S'inscrire</a></li>       
					
			<?php } ?>

			
                </ul>
            </div>
        </div>
    </div>
</div><!--/#navigation-->
<br><br><br><br><br><br><br><br>


//LE TRUC EN JS PROPRE
<div class="container">
  <div class="alert alert-info alert-dismissable col-lg-4" style="display: none">
    <button type="button" class="close">×</button>
      <h4>Attention!</h4> Petite information importante !
  </div>
  <div class="col-lg-3">
    <input type="button" class="btn btn-primary" id="afficher" value="Afficher l'alerte">
  </div>
</div>

<script>  
  $(function (){
    $("#afficher").click(function() {
      $("#afficher").hide();
      $(".alert").show("slow");
    }); 
    $(".close").click(function() {
      $(".alert").hide("slow");
      $("#afficher").show();
    }); 
  }); 
</script>
//LE TRUC EN JS PROPRE

//MODAL
<a data-toggle="modal" href="#infos" >Informations</a>
<div class="modal" id="infos">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">x</button>
        <h4 class="modal-title">Plus d'informations</h4>
      </div>
      <div class="modal-body">
        Le Tigre (Panthera tigris) est un mammifère carnivore de la famille des félidés...
      </div>
    </div>
  </div>
</div>
// MODAL

//ENVOI EMAIL PROOOOOOPREEEE
     <?php 
				
$mail = 'steve.alabi@hotmail.fr'; // Déclaration de l'adresse de destination.
if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) // On filtre les serveurs qui rencontrent des bogues.
{
	$passage_ligne = "\r\n";
}
else
{
	$passage_ligne = "\n";
}
//=====Déclaration des messages au format texte et au format HTML.
$message_txt = "Salut à tous, voici un e-mail envoyé par un script PHP.";
$message_html = "<html><head></head><body><b>Salut à tous</b>, voici un e-mail envoyé par un <i>script PHP</i>.</body></html>";
//==========
 
//=====Création de la boundary
$boundary = "-----=".md5(rand());
//==========
 
//=====Définition du sujet.
$sujet = "Hey mon ami !";
//=========
 
//=====Création du header de l'e-mail.
$header = "From: \"WeaponsB\"<steve.alabi@hotmail.fr.fr>".$passage_ligne;
$header.= "Reply-to: \"WeaponsB\" <steve.alabi@hotmail.fr>".$passage_ligne;
$header.= "MIME-Version: 1.0".$passage_ligne;
$header.= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;
//==========
 
//=====Création du message.
$message = $passage_ligne."--".$boundary.$passage_ligne;
//=====Ajout du message au format texte.
$message.= "Content-Type: text/plain; charset=\"ISO-8859-1\"".$passage_ligne;
$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
$message.= $passage_ligne.$message_txt.$passage_ligne;
//==========
$message.= $passage_ligne."--".$boundary.$passage_ligne;
//=====Ajout du message au format HTML
$message.= "Content-Type: text/html; charset=\"ISO-8859-1\"".$passage_ligne;
$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
$message.= $passage_ligne.$message_html.$passage_ligne;
//==========
$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
//==========
 
//=====Envoi de l'e-mail.
mail($mail,$sujet,$message,$header);
//==========
?>
//FIN ENVOI EMAIL PROOOOOOPREEEE


//CRYPTOGRAMME SECURITE

	<form action="monblog.php" method="post">
	<table>
	  <tr><td><img src="crypt/cryptographp.php"></td></tr>
	  <tr><td>Recopier le code:<input type="text" name="code"></td></tr>
	  <tr><td><input type="submit" name="submit" value="Envoyer"></td></tr>
	</table>
	</form>
	
	<?php
if(isset($_POST['submit'])){

	if ($_SESSION['cryptcode'] == md5($_POST['code']) and (!isset($_SESSION['cryptreload']))){
		echo "BRAVO";
	}
	
	else{
	   echo "ERREUR";
	   $_SESSION['cryptreload']='OUI';
   }
}		   
	?>

//FIN CRYPTOGRAMME SECURITE

 <br><br><br><br><br>

 
 
			
<footer id="footer" class="text-center">
    <center><p>Copyright © 2023 Fooye Indus. All rights reserved.</p></center>
</footer>
   <script src="assets/js/jquery.js"></script>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/main.js"></script>

</body>
</html>