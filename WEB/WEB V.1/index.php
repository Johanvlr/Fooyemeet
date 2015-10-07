<?php
session_start(); // On démarre la session AVANT toute chose
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=meet', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch(Exception $e)
{
	die('Erreur : '.$e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
       <meta name="description" content="Partage de Réseaux Social">
    <meta name="author" content="Fooye Industrie">
    <title>Fooye - Meet</title>
	
    <link rel="canonical" href="http://www.example.com" />
	
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet"> 
    <link href="css/main.css" rel="stylesheet">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="style.css"/>
	<link rel="stylesheet" href="css/animation.css">
   
    <link rel="shortcut icon" href="images/favicon.ico">

    <script type="text/javascript">
	<!--
	
            jQuery(function($)
            {
                $('.map').append('<div class="overlay">').append('<div class="tooltip">Salut les gens</div>')
                $('.map .tooltip').hide();
                var region = [
                    {name:'Seine-et-Marne', slug:'Seine-et-Marne'},
                    {name:'Essonne', slug:'Essonne'},
                    {name:'Val-de-Marne', slug:'Val-de-Marne'},
                    {name:'Seine-Saint-Denis', slug:'Seine-Saint-Denis'},
                    {name:'Val-d Oise', slug:'Val-d Oise'},
                    {name:'Paris', slug:'Paris'},
                    {name:'Hauts-de-Seine', slug:'Hauts-de-Seine'},
                    {name:'Yvelines', slug:'Yvelines'}];

                $(document).mousemove(function(e)
                {
                    $('.map .tooltip').css(
                    {
                        top:e.pageY-$('.map .tooltip').height()-20,
                        left:e.pageX-$('.map .tooltip').width()/2-10
                    });
                });

                $('.map area').mouseover(function()
                {
                    var index = $(this).index();
                    var left = -index * 490 - 490;
                    $('.map .tooltip').html(region[index].name).stop().fadeTo(500,0.6);
                    $('.map .overlay').css({backgroundPosition: left+"px 0px"});
                });

                $('.map').mouseout(function()
                {
                    $('.map .overlay').css({backgroundPosition: "490px 0px"});
                    $('.map .tooltip').stop().fadeTo(500,0);
                })
            });
			
	//-->
        </script>
		
</head><!--/head-->

<body>

	
<!--.preloader-->
<div class="preloader"><i class="fa fa-circle-o-notch fa-spin"></i></div>
<!--/.preloader-->

<header id="header"> 
    <div class="container">
        <div class="container-inner">
		
            <div class="menu pull-left">
                <a class="pull-left logo" href="index.php">
                    <h1><img class="img-responsive" src="images/logo.png" alt="logo"></h1>
                </a>
            </div>
			
				<?php 
			
				if(isset($_SESSION['conect'])){	
					if($_SESSION['conect']){	?>
			
					<div class="col-md-3 col-md-offset-2 search">
						<form method="get" action="code.php" class="menu pull-left">
						  <div class="form-group">
							<input type="search" name="nom" class="input-sm" placeholder="Recherche par nom">
							<button type="submit" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-eye-open"></span> Chercher</button>
						  </div>
						</form>
					</div>
			
				<?php 
					}
				}		?>
				
			
			
            <div class="menu pull-right">
			
			 
			<?php 
			
				if(isset($_SESSION['conect'])){	
					if($_SESSION['conect']){	
			
					
					$req = $bdd->prepare('SELECT id,nom,sexe,departement,origine,age FROM carte WHERE email = ?');
					$req->execute(array($_SESSION['email']));
					$donnees = $req->fetch();
					$_SESSION['pseudo']=$donnees['nom'];
					$_SESSION['sexe']=$donnees['sexe'];
					$_SESSION['departement']=$donnees['departement'];
					$_SESSION['origine']=$donnees['origine'];
					$_SESSION['age']=$donnees['age'];
					$_SESSION['id']=$donnees['id'];
					$_SESSION['logged']='on';
					
if($_SESSION['sexe'] == 'femme'){
	$rep=$bdd->prepare('SELECT COUNT(id_femme) AS max FROM demande_femme WHERE id_femme = ? AND acceptation != "oui" AND acceptation != "non" '); //compte le nombre de demande
	$rep->execute(array($_SESSION['id']));
	$num = $rep->fetch();
}
else{
	$rep1=$bdd->prepare('SELECT COUNT(id_homme) AS max FROM demande_femme WHERE id_homme = ? AND sayer != \'oui\' AND (acceptation = "oui" OR acceptation = "non") '); //compte le nombre de demande
	$rep1->execute(array($_SESSION['id']));
	$num = $rep1->fetch();
}


?>	<a href="profil-<?php echo $_SESSION['id']; ?>">	<?php

		if($num['max'] != 0){
?>			
			<button class="btn btn-danger">
<?php }else{ ?>		
			<button class="btn btn-primary">
<?php } ?>

					<strong>
					<i class="fa fa-user"></i> <?php echo htmlspecialchars($_SESSION['pseudo']); ?>
					</strong>
					<span class="badge text-success"><?php echo $num['max']; ?></span>	
			</button>	
					</a>		
			
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	
				
			<?php	}
				}	?>
			
			
			
			
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
					
                    <li><a href="profil-<?php echo $_SESSION['id']; ?>" data-target="#page-slider" data-slide-to="1">Mon Profil</a></li>
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

 <section id="welcome-page">
         <div class="container">
            <div class="row clearfix">
                <div class="col-md-12 column">
                    <div class="row clearfix">
                
			
			<div class="col-md-4 column"> 
			
			<?php
			
			if(isset($_SESSION['conect'])){		
			if($_SESSION['conect']){			//CONECETER ??
			
				if(isset($_GET['region']) AND ($_GET['region']=='Yvelines' OR $_GET['region']=='Seine.Saint.Denis' OR $_GET['region']=='Seine.et.Marne'OR $_GET['region']=='Val.d\'oise' OR 
												$_GET['region']=='Paris' OR $_GET['region']=='Hauts.de.Seine' OR $_GET['region']=='Essonne' OR $_GET['region']=='Val.de.Marne')){	//CHOISI REGION??
					//ETAPE 2 l'origine...
					
					if(isset($_GET['sexe']) AND ($_GET['sexe']=='homme' OR $_GET['sexe']=='femme')){ //CHOISIE SEXE ??
						
						if(isset($_GET['origine']) AND isset($_GET['page'])){ //CHOISIE ORIGINE ??
					
					
							$rep2=$bdd->prepare('SELECT COUNT(id) AS max FROM carte WHERE departement = ? AND origine = ? AND sexe = ?'); //compte le nomdre de personne pr la recherche
							$rep2->execute(array($_GET['region'], $_GET['origine'], $_GET['sexe']));
							$nbr = $rep2->fetch();
						
						$nbr_page = ((int)($nbr['max'] / 3)) + 1;
						$unite =(int)($_GET['page']);
						
						if($unite < 0 OR $unite > $nbr_page) $_GET['page'] = 1;
						
						if($unite > 0 AND $_GET['page'] == $unite AND $unite <= $nbr_page){ //PAGE PROPRE
						
					
						//ETAPE 3 Les cartes on y est...
											
											$page_min=($_GET['page'] - 1) * 3;
											
							$req = $bdd->prepare('SELECT* FROM carte LEFT JOIN inscri_femme ON carte.id = inscri_femme.id_femme WHERE departement = ? AND origine = ? AND sexe = ? LIMIT '.$page_min.', 3');
							$req->execute(array($_GET['region'], $_GET['origine'], $_GET['sexe']));
							
							
							
							
								?>	
							
<div class="container">
	<div class="row clearfix">
		<div class="col-md-14 column">
		
			<div class="col-md-1 column">
				<h3 style="text-transformation: uppercase;"><?php echo $_GET['region']; ?>
				<a style="float: right;" href="index.php"><span class="fa fa-edit"></span></a>
				</h3><hr><br>
				<h3 style="text-transformation: uppercase;"><?php echo $_GET['sexe']; ?>
				<a style="float: right;" href="index-<?php echo $_GET['region'];?>"><span class="fa fa-edit"></span></a>
				</h3><hr><br>
				<h3 style="text-transformation: uppercase;"><?php echo $_GET['origine']; ?>
				<a style="float: right;" href="index-<?php echo $_GET['region'];?>-<?php echo $_GET['sexe']; ?>"><span class="fa fa-edit"></span></a>
				</h3><hr><br>
			</div>

				
				<?php	
							if($nbr['max'] == 0){	?>
							
								<br /><br />
							<div class="col-md-10 col-md-offset-1">
								<div class="panel panel-primary">
								  <div class="panel-heading">
									<h3 class="panel-title">Oupss !!</h3>
								  </div>
								  
								  <div class="panel-body"><div class="text-center">
								  <font color="blue">Aucune personne trouvée</font>
								  </div></div>
								</div>
							</div>
								
								<?php
							}
							
						while($carte = $req->fetch()){	
				
				
				
							
				?>
				
				<div class="col-md-3 column">
						
	
			<?php if(!empty($carte['protection'])){ 
			
			$req1 = $bdd->prepare('SELECT * FROM demande_femme WHERE id_homme = ? AND id_femme= ? ');
			$req1->execute(array($_SESSION['id'],$carte['id_femme']));	
			$accept=$req1->fetch();
			
			if($carte['id_femme'] == $_SESSION['id']){ ?>
			
				<form class="form-horizontal" method="get" action="code.php">				
					<input type="hidden" name="profil" value="<?php echo $carte['id']; ?>"> <?php 
			
			}
		 
			else if($carte['protection']=='Sur demande' AND $accept['acceptation']!='oui'){ ?>
				
						<form class="form-horizontal" method="post" action="demande.php">
					
							<input type="hidden" name="region" value="<?php echo $_GET['region']; ?>"> 
							<input type="hidden" name="sexe" value="<?php echo $_GET['sexe']; ?>"> 
							<input type="hidden" name="origine" value="<?php echo $_GET['origine']; ?>">
							<input type="hidden" name="page" value="<?php echo $_GET['page']; ?>">
							<input type="hidden" name="demande" value="<?php echo $carte['id']; ?>">
						
			<?php }else if($carte['protection']=='Ouvert sur critère' AND $accept['acceptation']!='oui'){	// TEST PR LE PROTECTION
			
					if($carte['pro_dep'] AND !$carte['pro_origine'] AND !$carte['pro_age']){
						if($carte['departement'] != $_SESSION['departement']){ ?>
							<form class="form-horizontal" method="post" action="demande.php">
							
								<input type="hidden" name="region" value="<?php echo $_GET['region']; ?>"> 
								<input type="hidden" name="sexe" value="<?php echo $_GET['sexe']; ?>"> 
								<input type="hidden" name="origine" value="<?php echo $_GET['origine']; ?>">
								<input type="hidden" name="page" value="<?php echo $_GET['page']; ?>">
								<input type="hidden" name="demande" value="<?php echo $carte['id']; ?>"> 
			<?php		}else{	?>
							<form class="form-horizontal" method="get" action="code.php">
								<?php
									$re = $bdd->prepare('SELECT id FROM droit WHERE id_demandeur = ? AND id_demander= ? ');
									$re->execute(array($_SESSION['id'],$carte['id']));	
									$droit=$re->fetch();
									if(!$droit['id']){ 
										//LA PERSONNE A LE DROIT DE VOIR LE PROFIL
											$req3 = $bdd->prepare('INSERT INTO droit(id_demandeur, id_demander) VALUES (?, ?)');
											$req3->execute(array($_SESSION['id'], $carte['id']));
										//LA PERSONNE A LE DROIT DE VOIR LE PROFIL
									}
								?>
								<input type="hidden" name="profil" value="<?php echo $carte['id']; ?>"> <?php }
			
					}if($carte['pro_origine'] AND !$carte['pro_age'] AND !$carte['pro_dep']){	
						if($carte['origine'] != $_SESSION['origine']){  ?>
						<form class="form-horizontal" method="post" action="demande.php">
						
							<input type="hidden" name="region" value="<?php echo $_GET['region']; ?>">
							<input type="hidden" name="sexe" value="<?php echo $_GET['sexe']; ?>"> 
							<input type="hidden" name="origine" value="<?php echo $_GET['origine']; ?>">
							<input type="hidden" name="page" value="<?php echo $_GET['page']; ?>">
							<input type="hidden" name="demande" value="<?php echo $carte['id']; ?>"> 
			<?php		}else{	?> 
						<form class="form-horizontal" method="get" action="code.php">
							<?php
								$re = $bdd->prepare('SELECT id FROM droit WHERE id_demandeur = ? AND id_demander= ? ');
								$re->execute(array($_SESSION['id'],$carte['id']));	
								$droit=$re->fetch();
								if(!$droit['id']){ 
									//LA PERSONNE A LE DROIT DE VOIR LE PROFIL
										$req3 = $bdd->prepare('INSERT INTO droit(id_demandeur, id_demander) VALUES (?, ?)');
										$req3->execute(array($_SESSION['id'], $carte['id']));
									//LA PERSONNE A LE DROIT DE VOIR LE PROFIL
								}
							?>
							<input type="hidden" name="profil" value="<?php echo $carte['id']; ?>"> <?php }
			
					}if($carte['pro_age'] AND !$carte['pro_dep'] AND !$carte['pro_origine']){
						if($carte['age_min'] >= $_SESSION['age'] OR $carte['age_max'] <= $_SESSION['age']){	?>
						<form class="form-horizontal" method="post" action="demande.php">
						
							<input type="hidden" name="region" value="<?php echo $_GET['region']; ?>"> 
							<input type="hidden" name="sexe" value="<?php echo $_GET['sexe']; ?>"> 
							<input type="hidden" name="origine" value="<?php echo $_GET['origine']; ?>">
							<input type="hidden" name="page" value="<?php echo $_GET['page']; ?>">
							<input type="hidden" name="demande" value="<?php echo $carte['id']; ?>"> 
			<?php 		}else{	?> 
						<form class="form-horizontal" method="get" action="code.php">
							<?php
								$re = $bdd->prepare('SELECT id FROM droit WHERE id_demandeur = ? AND id_demander= ? ');
								$re->execute(array($_SESSION['id'],$carte['id']));	
								$droit=$re->fetch();
								if(!$droit['id']){ 
									//LA PERSONNE A LE DROIT DE VOIR LE PROFIL
										$req3 = $bdd->prepare('INSERT INTO droit(id_demandeur, id_demander) VALUES (?, ?)');
										$req3->execute(array($_SESSION['id'], $carte['id']));
									//LA PERSONNE A LE DROIT DE VOIR LE PROFIL
								}
							?>
							<input type="hidden" name="profil" value="<?php echo $carte['id']; ?>"> <?php }
			
					}if($carte['pro_dep'] AND $carte['pro_origine']){
						if(($carte['departement'] != $_SESSION['departement']) AND ($carte['origine'] != $_SESSION['origine'])){ ?>
						<form class="form-horizontal" method="post" action="demande.php">
						
							<input type="hidden" name="region" value="<?php echo $_GET['region']; ?>"> 
							<input type="hidden" name="sexe" value="<?php echo $_GET['sexe']; ?>"> 
							<input type="hidden" name="origine" value="<?php echo $_GET['origine']; ?>">
							<input type="hidden" name="page" value="<?php echo $_GET['page']; ?>">
							<input type="hidden" name="demande" value="<?php echo $carte['id']; ?>"> 
			<?php		}else{	?> 
						<form class="form-horizontal" method="get" action="code.php">
							<?php
								$re = $bdd->prepare('SELECT id FROM droit WHERE id_demandeur = ? AND id_demander= ? ');
								$re->execute(array($_SESSION['id'],$carte['id']));	
								$droit=$re->fetch();
								if(!$droit['id']){ 
									//LA PERSONNE A LE DROIT DE VOIR LE PROFIL
										$req3 = $bdd->prepare('INSERT INTO droit(id_demandeur, id_demander) VALUES (?, ?)');
										$req3->execute(array($_SESSION['id'], $carte['id']));
									//LA PERSONNE A LE DROIT DE VOIR LE PROFIL
								}
							?>
							<input type="hidden" name="profil" value="<?php echo $carte['id']; ?>"> <?php }
			
					}if($carte['pro_dep'] AND $carte['pro_age']){
						if(($carte['departement'] != $_SESSION['departement']) AND ($carte['age_min'] >= $_SESSION['age'] OR $carte['age_max'] <= $_SESSION['age'])){ ?>
						<form class="form-horizontal" method="post" action="demande.php">
						
							<input type="hidden" name="region" value="<?php echo $_GET['region']; ?>"> 
							<input type="hidden" name="sexe" value="<?php echo $_GET['sexe']; ?>"> 
							<input type="hidden" name="origine" value="<?php echo $_GET['origine']; ?>">
							<input type="hidden" name="page" value="<?php echo $_GET['page']; ?>">
							<input type="hidden" name="demande" value="<?php echo $carte['id']; ?>"> 
			<?php		}else{	?> 
						<form class="form-horizontal" method="get" action="code.php">
						<div class="form-group">
							<?php
								$re = $bdd->prepare('SELECT id FROM droit WHERE id_demandeur = ? AND id_demander= ? ');
								$re->execute(array($_SESSION['id'],$carte['id']));	
								$droit=$re->fetch();
								if(!$droit['id']){ 
									//LA PERSONNE A LE DROIT DE VOIR LE PROFIL
										$req3 = $bdd->prepare('INSERT INTO droit(id_demandeur, id_demander) VALUES (?, ?)');
										$req3->execute(array($_SESSION['id'], $carte['id']));
									//LA PERSONNE A LE DROIT DE VOIR LE PROFIL
								}
							?>
							<input type="hidden" name="profil" value="<?php echo $carte['id']; ?>"> <?php }
			
					}if($carte['pro_origine'] AND $carte['pro_age']){
						if(($carte['origine'] != $_SESSION['origine']) AND ($carte['age_min'] >= $_SESSION['age'] OR $carte['age_max'] <= $_SESSION['age'])){ ?>
						<form class="form-horizontal" method="post" action="demande.php">
						
							<input type="hidden" name="region" value="<?php echo $_GET['region']; ?>"> 
							<input type="hidden" name="sexe" value="<?php echo $_GET['sexe']; ?>"> 
							<input type="hidden" name="origine" value="<?php echo $_GET['origine']; ?>">
							<input type="hidden" name="page" value="<?php echo $_GET['page']; ?>">
							<input type="hidden" name="demande" value="<?php echo $carte['id']; ?>"> 
			<?php		}else{	?> 
						<form class="form-horizontal" method="get" action="code.php">
							<?php
								$re = $bdd->prepare('SELECT id FROM droit WHERE id_demandeur = ? AND id_demander= ? ');
								$re->execute(array($_SESSION['id'],$carte['id']));	
								$droit=$re->fetch();
								if(!$droit['id']){ 
									//LA PERSONNE A LE DROIT DE VOIR LE PROFIL
										$req3 = $bdd->prepare('INSERT INTO droit(id_demandeur, id_demander) VALUES (?, ?)');
										$req3->execute(array($_SESSION['id'], $carte['id']));
									//LA PERSONNE A LE DROIT DE VOIR LE PROFIL
								}
							?>
							<input type="hidden" name="profil" value="<?php echo $carte['id']; ?>"> <?php }
			
					}if($carte['pro_origine'] AND $carte['pro_age'] AND $carte['pro_dep']){
						if(($carte['origine'] != $_SESSION['origine']) AND ($carte['departement'] != $_SESSION['departement']) AND ($carte['age_min'] >= $_SESSION['age'] OR $carte['age_max'] <= $_SESSION['age'])){ ?>
						<form class="form-horizontal" method="post" action="demande.php">
						
							<input type="hidden" name="region" value="<?php echo $_GET['region']; ?>"> 
							<input type="hidden" name="sexe" value="<?php echo $_GET['sexe']; ?>"> 
							<input type="hidden" name="origine" value="<?php echo $_GET['origine']; ?>">
							<input type="hidden" name="page" value="<?php echo $_GET['page']; ?>">
							<input type="hidden" name="demande" value="<?php echo $carte['id']; ?>"> 
			<?php		}else{	?>
						<form class="form-horizontal" method="get" action="code.php">
							<?php
								$re = $bdd->prepare('SELECT id FROM droit WHERE id_demandeur = ? AND id_demander= ? ');
								$re->execute(array($_SESSION['id'],$carte['id']));	
								$droit=$re->fetch();
								if(!$droit['id']){ 
									//LA PERSONNE A LE DROIT DE VOIR LE PROFIL
										$req3 = $bdd->prepare('INSERT INTO droit(id_demandeur, id_demander) VALUES (?, ?)');
										$req3->execute(array($_SESSION['id'], $carte['id']));
									//LA PERSONNE A LE DROIT DE VOIR LE PROFIL
								}
							?>
							<input type="hidden" name="profil" value="<?php echo $carte['id']; ?>"> <?php }
					}
				}
				
				
				else if($accept['acceptation'] == 'oui' OR $carte['protection'] == 'Ouvert à tous'){	?>
					<form class="form-horizontal" method="get" action="code.php">
						<?php
							$re = $bdd->prepare('SELECT id FROM droit WHERE id_demandeur = ? AND id_demander= ? ');
							$re->execute(array($_SESSION['id'],$carte['id']));	
							$droit=$re->fetch();
							if(!$droit['id']){ 
								//LA PERSONNE A LE DROIT DE VOIR LE PROFIL
									$req3 = $bdd->prepare('INSERT INTO droit(id_demandeur, id_demander) VALUES (?, ?)');
									$req3->execute(array($_SESSION['id'], $carte['id']));
								//LA PERSONNE A LE DROIT DE VOIR LE PROFIL
							}
						?>
						<input type="hidden" name="profil" value="<?php echo $carte['id']; ?>"> 	
		<?php }
			
			
	}else{	?>
		<form class="form-horizontal" method="get" action="code.php">
			<?php
				$re = $bdd->prepare('SELECT id FROM droit WHERE id_demandeur = ? AND id_demander= ? ');
				$re->execute(array($_SESSION['id'],$carte['id']));	
				$droit=$re->fetch();
				if(!$droit['id']){ 
					//LA PERSONNE A LE DROIT DE VOIR LE PROFIL
						$req3 = $bdd->prepare('INSERT INTO droit(id_demandeur, id_demander) VALUES (?, ?)');
						$req3->execute(array($_SESSION['id'], $carte['id']));
					//LA PERSONNE A LE DROIT DE VOIR LE PROFIL
				}
			?>
		 	<input type="hidden" name="profil" value="<?php echo $carte['id']; ?>"> 
	<?php }
	?>
						

						<div class="our-plan-parlex">
						  <div class="w-container">
							<div class="wrap">
								<div class="w-col w-col-3">
	
									<div class="plan1">
										<div class="plan1-ser1">
										
										  <h4><?php echo htmlspecialchars($carte['nom']); ?></h4>
										  <div class="price"><?php echo $carte['age'].' / '.htmlspecialchars($carte['pays']); ?> </div>
										</div><br />
									
										<p class="plan1-ser1-para">
										<?php
										if($carte['facebook'])	echo '<span class="fa fa-facebook"></span> Facebook ---> <span class="glyphicon glyphicon-ok"></span><br /><br />';
										
										else echo '<span class="fa fa-facebook"></span>Facebook ---> <span class="glyphicon glyphicon-remove"></span><br /><br />';
										
										if($carte['insta'])	echo '<span class="fa fa-instagram"></span> Instagram---> <span class="glyphicon glyphicon-ok"></span><br /><br />';
										
										else echo '<span class="fa fa-instagram"></span>Instagram ---> <span class="glyphicon glyphicon-remove"></span><br /><br />';
										
										if($carte['snap'])	echo '<span class="fa fa-camera"></span> Snapchat ---> <span class="glyphicon glyphicon-ok"></span><br /><br />';
										
										else echo '<span class="fa fa-camera"></span>Snapchat ---> <span class="glyphicon glyphicon-remove"></span><br /><br />';
										
										if($carte['twitter'])	echo '<span class="fa fa-twitter"></span> Twitter ---> <span class="glyphicon glyphicon-ok"></span><br /><br />';
										
										else echo '<span class="fa fa-twitter"></span>Twitter ---> <span class="glyphicon glyphicon-remove"></span><br /><br />';
										?> 
										</p> 
										
										
										
 <?php	 if(!empty($carte['protection'])){ 
		 
			$req1 = $bdd->prepare('SELECT * FROM demande_femme WHERE id_homme = ? AND id_femme= ? ');
			$req1->execute(array($_SESSION['id'],$carte['id_femme']));	
			$accept=$req1->fetch();
			
			if($carte['id_femme'] == $_SESSION['id']){ ?>
			
				<div class="plan-1-butn"><button type="submit">Voir le profil</button></div> <?php 
			
			}
		 
			else if($carte['protection']=='Sur demande' AND $accept['acceptation']!='oui'){  
			
			if($accept['id']){ ?>	<div class="plan-1-butn"><button>Demande envoyer</button></div>
		<?php }else{	?>			<div class="plan-1-butn"><button type="submit">Faire une demande</button></div>
		
						
			<?php } }else if($carte['protection']=='Ouvert sur critère' AND $accept['acceptation']!='oui'){	// TEST PR LE PROTECTION
			
					if($carte['pro_dep'] AND !$carte['pro_origine'] AND !$carte['pro_age']){
						if($carte['departement'] != $_SESSION['departement']){ 
						
					if($accept['id']){ ?>	<div class="plan-1-butn"><button>Demande envoyer</button></div>
				<?php }else{	?>			<div class="plan-1-butn"><button type="submit">Faire une demande</button></div>
		
			<?php	}	}else{	?> <div class="plan-1-butn"><button type="submit">Voir le profil</button></div> <?php }
			
					}if($carte['pro_origine'] AND !$carte['pro_age'] AND !$carte['pro_dep']){	
						if($carte['origine'] != $_SESSION['origine']){  
						
					if($accept['id']){ ?>	<div class="plan-1-butn"><button>Demande envoyer</button></div>
					<?php }else{	?>		<div class="plan-1-butn"><button type="submit">Faire une demande</button></div> 
					
			<?php	}	}else{	?> <div class="plan-1-butn"><button type="submit">Voir le profil</button></div> <?php }
			
					}if($carte['pro_age'] AND !$carte['pro_dep'] AND !$carte['pro_origine']){
						if($carte['age_min'] >= $_SESSION['age'] OR $carte['age_max'] <= $_SESSION['age']){	
						
						if($accept['id']){ ?>	<div class="plan-1-butn"><button>Demande envoyer</button></div>
					<?php }else{	?>			<div class="plan-1-butn"><button type="submit">Faire une demande</button></div> 
		
			<?php 	}	}else{	?> <div class="plan-1-butn"><button type="submit">Voir le profil</button></div> <?php }
			
					}if($carte['pro_dep'] AND $carte['pro_origine']){
						if(($carte['departement'] != $_SESSION['departement']) AND ($carte['origine'] != $_SESSION['origine'])){ 
						
						if($accept['id']){ ?>	<div class="plan-1-butn"><button>Demande envoyer</button></div>
					<?php }else{	?>			<div class="plan-1-butn"><button type="submit">Faire une demande</button></div>
					
			<?php	}	}else{	?> <div class="plan-1-butn"><button type="submit">Voir le profil</button></div> <?php }
			
					}if($carte['pro_dep'] AND $carte['pro_age']){
						if(($carte['departement'] != $_SESSION['departement']) AND ($carte['age_min'] >= $_SESSION['age'] OR $carte['age_max'] <= $_SESSION['age'])){ 
						
						if($accept['id']){ ?>	<div class="plan-1-butn"><button>Demande envoyer</button></div>
					<?php }else{	?>			<div class="plan-1-butn"><button type="submit">Faire une demande</button></div> 
					
			<?php	}	}else{	?> <div class="plan-1-butn"><button type="submit">Voir le profil</button></div> <?php }
			
					}if($carte['pro_origine'] AND $carte['pro_age']){
						if(($carte['origine'] != $_SESSION['origine']) AND ($carte['age_min'] >= $_SESSION['age']OR $carte['age_max'] <= $_SESSION['age'])){ 
						
						if($accept['id']){ ?>	<div class="plan-1-butn"><button>Demande envoyer</button></div>
					<?php }else{	?>			<div class="plan-1-butn"><button type="submit">Faire une demande</button></div>
					
			<?php	}	}else{	?> <div class="plan-1-butn"><button type="submit">Voir le profil</button></div> <?php }
			
					}if($carte['pro_origine'] AND $carte['pro_age'] AND $carte['pro_dep']){
						if(($carte['origine'] != $_SESSION['origine']) AND ($carte['departement'] != $_SESSION['departement']) AND ($carte['age_min'] >= $_SESSION['age'] OR $carte['age_max'] <= $_SESSION['age'])){ 
						
						if($accept['id']){ ?>	<div class="plan-1-butn"><button>Demande envoyer</button></div>
					<?php }else{	?>			<div class="plan-1-butn"><button type="submit">Faire une demande</button></div>
					
			<?php	}	}else{	?> <div class="plan-1-butn"><button type="submit">Voir le profil</button></div> <?php }
					}
					
				}//TEST PR LA PROTECTION
				
				else if($accept['acceptation'] == 'oui' OR $carte['protection'] == 'Ouvert à tous'){	//OUVERT A TOUS ?>
				
						<div class="plan-1-butn"><button type="submit">Voir le profil</button></div> 	
			<?php } 
				
	}else{	//SI C UN MEC?>
		
				<div class="plan-1-butn"><button type="submit">Voir le profil</button></div> 	
	<?php }
	?>

									
										
									</div>
								</div>
							</div>
							</div>	
						</div>
				  
						
					</form>


				</div>
				
				<div class="col-md-1 column">
				
				</div>
				
				<?php	}	//ferme la boucle	?>
		
			
		</div>
	</div>
				<?php $nbr_page = ((int)($nbr['max'] / 3)) + 1; 
					
					if($nbr['max'] == 0 OR $_GET['page'] > $nbr_page OR $nbr['max'] <= 3){
					
					
					}
					else{
				?>
				
				<ul class="pager">
				
	<?php  	if($_GET['page'] >= $nbr_page){ ?>
				<li class="previous"><a href="index-<?php echo $_GET['region'];?>-<?php echo $_GET['sexe']; ?>-<?php echo $_GET['origine'];?>-<?php echo $_GET['page']-1;?>"><font color="blue">&larr; Précedent</font></a></li>
				  
	<?php  	}if($_GET['page'] < $nbr_page){ ?>	
				<li class="next"><a href="index-<?php echo $_GET['region'];?>-<?php echo $_GET['sexe']; ?>-<?php echo $_GET['origine'];?>-<?php echo $_GET['page']+1;?>"><font color="blue">Suivant &rarr;</font></a></li>
						
				<?php } } ?>
				</ul>
</div>

									
<?php
								echo '<br /><br />';
								
						} //FIN PAGE PRORE
						else{	//PAGE INEXISANTE ?>
							
								<br /><br />
							<div class="col-md-10">
								<div class="panel panel-primary">
								  <div class="panel-heading">
									<h3 class="panel-title">Erreur !!</h3>
								  </div>
								  
								  <div class="panel-body"><div class="text-center">
								  <font color="blue">La page demandé est vide ou incorrecte </font>
								  </div></div>
								</div>
							</div>
								
								<?php
						
						}
						
					}	
					else{		// PAS CHOISI ORIGINE !!!
					
						
			?>
				<h3 style="text-transformation: uppercase;"><?php echo $_GET['region']; ?>
				<a style="float: right;" href="index.php"><span class="fa fa-edit"></span></a>
				</h3><hr>
				<h3 style="text-transformation: uppercase;"><?php echo $_GET['sexe']; ?>
				<a style="float: right;" href="index-<?php echo $_GET['region'];?>"><span class="fa fa-edit"></span></a>
				</h3><hr><br>
				
			
				
			<div class="container">
				<div class="row clearfix">
					<div class="col-md-12 column">
									
						<div class="col-md-3 column">
						</div>
			
						<div class="col-md-5 column">
				
							<form class="form-horizontal" method="get" action="code.php">
						
							 <div class="form-group">
							  <label for="sel1">Choisie Une Origine</label>
							  <input type="hidden" name="region" value="<?php echo $_GET['region']; ?>"> 
							  <input type="hidden" name="sexe" value="<?php echo $_GET['sexe']; ?>"> 
							  
							  <select name="origine" class="form-control" id="sel1" required="required">
								<option value="">Origine &#8595;</option>
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
								<input type="hidden" name="page" value="1"> 
								
							</div>
					
							<input type="submit" value="Submit" class="btn btn-primary pull-right">
						
						</form>
						
						</div>
					</div>
				</div>
			</div>
				
				<?php
						}
						
						
						}
						else{	//PAS CHOISIE SEX
						?>
								
								
								<h3 style="text-transformation: uppercase;"><?php echo $_GET['region']; ?>
								<a style="float: right;" href="index.php"><span class="fa fa-edit"></span></a>
								</h3><hr><br>
								
							<div class="container">
							<div class="row clearfix">
							<div class="col-md-2 ">
							</div>
							 <div class="col-md-2 ">
								<p class="text-center">
									<h3>Je recherche :</h3> 
								</p>
							  </div>
								<a href="index-<?php echo $_GET['region']; ?>-homme" >
							  <div class="col-xs-4 col-sm-3 col-md-3 sexe">
								  <img src="images/test.png" alt="Tigre" class="img-rounded">
							  </div>
								</a>
							  <div class="col-md-1 ">
							  </div>
								<a href="index-<?php echo $_GET['region']; ?>-femme">
							  <div class="col-xs-4 col-sm-3 col-md-3 sexe">
								  <img src="images/meuf.png" alt="Tigre" class="img-rounded">
							  </div>
								</a>
							</div>
							</div>
						
						
						<?php
						}
						
				}
				else{		//PAS CHOISIE REGION !!!
				?>
	<div class="container">
		<div class="row clearfix">
			<div class="col-md-12 column">
				<div class="row clearfix">
			
					<div class="col-md-3">
						
					</div>
					

					<div class="col-md-3 ">
			
						<div class="map">
							<img src="void.png" width="490" height="415" usemap="#Map">
								<map name="Map">
						
						  <area shape="poly" coords="232,334,247,318,248,296,249,269,252,243,257,222,258,210,265,202,268,191,268,177,268,168,263,
													167,265,138,268,128,267,120,264,104,258,98,256,97,263,85,266,72,276,63,286,64,292,77,305,78,308,
													67,363,71,379,55,406,81,400,97,473,153,451,183,461,185,471,203,469,225,484,223,488,234,457,277,
													458,309,411,326,370,323,368,356,375,363,324,408,310,391,301,404,236,407,236,395,249,390,250,366,
													227,363,221,343" href="index-Seine.et.Marne">	<!-- 77 -->
													
						  <area shape="poly" coords="119,349,132,349,145,349,158,348,167,340,178,331,183,331,184,339,224,337,238,325,246,314,246,280,
													248,256,251,235,256,209,248,205,247,195,239,198,233,200,223,201,213,203,210,191,203,190,199,195,
													195,196,191,186,179,183,174,178,170,183,163,189,154,198,151,204,149,212,140,210,135,211,132,216,
													129,225,141,232,140,238,139,245,131,251,108,253,117,260,112,274,107,288,111,288,126,320,120,337"
													href="index-Essonne">	<!-- 91 -->
													
						  <area shape="poly" coords="255,211,264,198,265,187,267,173,250,161,239,153,230,151,235,164,224,164,209,165,201,169,201,182,
													204,190,214,193,214,202,247,195" href="index-Val.de.Marne">	<!-- 94 -->
													
						  <area shape="poly" coords="252,98,245,106,237,114,192,114,193,119,203,120,202,126,199,134,209,132,219,132,222,156,230,147,242,
													149,261,165,261,141,264,129,262,112,258,99" href="index-Seine.Saint.Denis">	<!-- 93 -->
													
						  <area shape="poly" coords="61,19,66,26,62,37,81,41,105,39,136,38,146,30,158,43,177,39,191,48,205,37,263,70,258,89,235,112,214,
													112,193,111,188,121,174,130,171,114,161,103,148,96,141,93,140,98,126,97,111,87,101,84,94,89,92,78,81,
													72,68,76,63,81,43,71,54,30" href="index-Val.d'oise"> <!-- 95 -->
													
						  <area shape="poly" coords="228,153,222,158,216,150,217,140,215,137,209,136,198,138,186,142,180,147,185,156,194,161,205,163,216,
													161,233,161" href="index-Paris">	<!-- 75 -->
													
						  <area shape="poly" coords="193,120,201,123,198,132,185,140,180,145,181,154,189,161,199,166,201,183,203,189,198,194,196,188,192,
													184,183,181,176,173,169,167,163,166,165,157,165,148,165,138,169,135,179,130"
													href="index-Hauts.de.Seine">	<!-- 92 -->
													
						  <area shape="poly" coords="1,84,41,74,64,85,77,74,88,76,92,89,100,88,111,89,122,97,131,102,141,100,146,97,166,112,171,126,169,
													134,160,136,163,148,160,168,167,171,171,178,162,188,150,201,147,210,139,209,131,214,128,222,131,230,
													138,233,136,244,128,250,114,251,107,253,115,263,111,273,105,288,98,295,86,290,78,282,77,256,63,247,
													62,239,38,223,34,206,40,193,31,171,36,158,7,115" href="index-Yvelines">	<!-- 78 -->
													
								</map>
				</div>
								
					</div>
					
				</div>
			</div>
		</div>
	</div>
	
		
		<?php 	}
			}
			}
			
			else{		//PAS CONECTER !!!	
			?>		
	<div class="container">
		<div class="row clearfix">
			<div class="col-md-12 column">
				<div class="row clearfix">
			
					<div class="col-md-3 column">
					</div>
			
					<div class="col-md-2 column">
						<div class="map">
							<img src="void.png" width="490" height="415" usemap="#Map">
							<map name="Map">
						
						  <area shape="poly" coords="232,334,247,318,248,296,249,269,252,243,257,222,258,210,265,202,268,191,268,177,268,168,263,
													167,265,138,268,128,267,120,264,104,258,98,256,97,263,85,266,72,276,63,286,64,292,77,305,78,308,
													67,363,71,379,55,406,81,400,97,473,153,451,183,461,185,471,203,469,225,484,223,488,234,457,277,
													458,309,411,326,370,323,368,356,375,363,324,408,310,391,301,404,236,407,236,395,249,390,250,366,
													227,363,221,343" href="javascript:alert('Vous devez vous conecter !!');" >	<!-- 77 -->
													
						  <area shape="poly" coords="119,349,132,349,145,349,158,348,167,340,178,331,183,331,184,339,224,337,238,325,246,314,246,280,
													248,256,251,235,256,209,248,205,247,195,239,198,233,200,223,201,213,203,210,191,203,190,199,195,
													195,196,191,186,179,183,174,178,170,183,163,189,154,198,151,204,149,212,140,210,135,211,132,216,
													129,225,141,232,140,238,139,245,131,251,108,253,117,260,112,274,107,288,111,288,126,320,120,337"
													href="javascript:alert('Vous devez vous conecter !!');">	<!-- 91 -->
													
						  <area shape="poly" coords="255,211,264,198,265,187,267,173,250,161,239,153,230,151,235,164,224,164,209,165,201,169,201,182,
													204,190,214,193,214,202,247,195" href="javascript:alert('Vous devez vous conecter !!');">	<!-- 94 -->
													
						  <area shape="poly" coords="252,98,245,106,237,114,192,114,193,119,203,120,202,126,199,134,209,132,219,132,222,156,230,147,242,
													149,261,165,261,141,264,129,262,112,258,99" href="javascript:alert('Vous devez vous conecter !!');">	<!-- 93 -->
													
						  <area shape="poly" coords="61,19,66,26,62,37,81,41,105,39,136,38,146,30,158,43,177,39,191,48,205,37,263,70,258,89,235,112,214,
													112,193,111,188,121,174,130,171,114,161,103,148,96,141,93,140,98,126,97,111,87,101,84,94,89,92,78,81,
													72,68,76,63,81,43,71,54,30" href="javascript:alert('Vous devez vous conecter !!');"> <!-- 95 -->
													
						  <area shape="poly" coords="228,153,222,158,216,150,217,140,215,137,209,136,198,138,186,142,180,147,185,156,194,161,205,163,216,
													161,233,161" href="javascript:alert('Vous devez vous conecter !!');">	<!-- 75 -->
													
						  <area shape="poly" coords="193,120,201,123,198,132,185,140,180,145,181,154,189,161,199,166,201,183,203,189,198,194,196,188,192,
													184,183,181,176,173,169,167,163,166,165,157,165,148,165,138,169,135,179,130"
													href="javascript:alert('Vous devez vous conecter !!');">	<!-- 92 -->
													
						  <area shape="poly" coords="1,84,41,74,64,85,77,74,88,76,92,89,100,88,111,89,122,97,131,102,141,100,146,97,166,112,171,126,169,
													134,160,136,163,148,160,168,167,171,171,178,162,188,150,201,147,210,139,209,131,214,128,222,131,230,
													138,233,136,244,128,250,114,251,107,253,115,263,111,273,105,288,98,295,86,290,78,282,77,256,63,247,
													62,239,38,223,34,206,40,193,31,171,36,158,7,115" href="javascript:alert('Vous devez vous conecter !!');">	<!-- 78 -->
													
						</map>
					</div>
					</div>		
				</div>
			</div>
		</div>
	</div>
		
		
		
		</div>

<?php		}	?>			

	 <div class="modal fade" id="infos">
       <div class="modal-dialog">  
          <div class="modal-content"></div>  
        </div> 
      </div>

			</div>
                 
                    </div>
                </div>
            </div>
        </div>
        
	</section>
 <br><br><br><br><br>

<footer id="footer" class="text-center">
    
		<div class="navbar navbar-inverse navbar-fixed-bottom" role="navigation">
			<div class="container">
				<div class="row clearfix">
							<div class="col-md-2 column" class="pull-left"><br>
							<li><a href="#">Mentions légale </a> </li> 
			
							<li><a data-toggle="modal" href="CGU.html" data-target="#infos" >Conditions d'Utilisation</a></li>	
				
							<li><a href="#">Aide </a> </li>
							</div>
							
							<div class="col-md-3 column" class="pull-left"><br>
							<li><a href="#">A propos </a> </li>
							<li><a href="#">Confidentialité </a> </li>
							<li><a href="#">Emplacement </a> </li>
							</div>
							
							<div class="col-md-4 column">
								
								<h1><img class="img-responsive" src="images/logo.png" alt="logo"></h1>
							
							</div>
							<div class="col-md-1 column">
							</div>
							<div class="col-md-3 column"><br>
							<div class="text-center center-block">
											<a href="https://www.facebook.com/bootsnipp"><i id="social" class="fa fa-facebook-square fa-3x social-fb"></i></a>
											<a href="https://twitter.com/bootsnipp"><i id="social" class="fa fa-twitter-square fa-3x social-tw"></i></a>
											<a href="https://plus.google.com/+Bootsnipp-page"><i id="social" class="fa fa-google-plus-square fa-3x social-gp"></i></a>
											<a href="mailto:bootsnipp@gmail.com"><i id="social" class="fa fa-envelope-square fa-3x social-em"></i></a>
								 </div>
							</div>
				</div>
				<center><p>Copyright © 2023 Fooye Indus. All rights reserved.</p></center>
			</div>
		</div>
</footer>

   <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
	<script>
	$('#myTab a').click(function (e) {
	  e.preventDefault()
	  $(this).tab('show')
	})	
	</script>   
	<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>  
<script type="text/javascript" src="js/main.js"></script>


<script langage="javascript">
<!--
      window.___gcfg = {
        lang: 'en-US'
      };

      (function() {
        var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
        po.src = 'https://apis.google.com/js/plusone.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
      })();
    	
//-->
</script>
</body>
</html>