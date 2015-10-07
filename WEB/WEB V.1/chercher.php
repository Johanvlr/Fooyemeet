<?php session_start(); 
try { 
		if((!isset($_SESSION['conect'])  && empty($_SESSION['conect'])) || empty($_GET['nom'])){
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
       <meta name="description" content="Recherche">
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
				
                    <li><a href="index.php" data-target="#page-slider" data-slide-to="0">Home</a></li>
                    <li class="active"><a href="#" data-target="#page-slider" data-slide-to="1">Mon Profil</a></li>
                    <li><a href="deco.php" data-target="#page-slider" data-slide-to="2">Se Déconecter</a></li>
					
                </ul>
            </div>
        </div>
    </div>
</div><!--/#navigation-->

	<section id="welcome-page">
		<div class="container">
			<div class="row clearfix">
				<div class="col-md-14 column ">

<?php
		if(isset($_GET['nom'])){	
			if($_GET['nom']){

				$req = $bdd->prepare('SELECT* FROM carte LEFT JOIN inscri_femme ON carte.id = inscri_femme.id_femme WHERE nom = ?');
				$req->execute(array($_GET['nom']));
				?>
				
		
		
			<div class="col-md-1 column">
				
			</div>

								
				
								<?php
			$rep2=$bdd->prepare('SELECT COUNT(id) AS max FROM carte WHERE nom = ?'); //compte le nomdre de personne pr la recherche
			$rep2->execute(array($_GET['nom']));
			$nbr = $rep2->fetch();	
							
						if($nbr['max'] == 0){	?>
						
							<br /><br />
							<div class="col-md-10 col-md-offset-1">
								<div class="panel panel-primary">
								  <div class="panel-heading">
									<h3 class="panel-title">Oupss !!</h3>
								  </div>
								  
								  <div class="panel-body"><div class="text-center">
								  <font color="blue">aucune personne correspondant a votre recherche</font>
								  </div></div>
								</div>
							</div>
						
						<?php
						}
						
						while($carte = $req->fetch()){
						
			
							
							
?>				<div class="col-md-3 column">	<?php
							
						if(!empty($carte['protection'])){ 
			
			$req1 = $bdd->prepare('SELECT * FROM demande_femme WHERE id_homme = ? AND id_femme= ? ');
			$req1->execute(array($_SESSION['id'],$carte['id_femme']));	
			$accept=$req1->fetch();
			
			if($carte['id_femme'] == $_SESSION['id']){ ?>
			
				<form class="form-horizontal" method="get" action="code.php">				
					<input type="hidden" name="profil" value="<?php echo $carte['id']; ?>"> <?php 
			
			}
		 
			else if($carte['protection']=='Sur demande' AND $accept['acceptation']!='oui'){ ?>
				
						<form class="form-horizontal" method="post" action="demande.php">
						
							<input type="hidden" name="region" value="<?php echo $carte['departement']; ?>"> 
							<input type="hidden" name="sexe" value="<?php echo $carte['sexe']; ?>"> 
							<input type="hidden" name="origine" value="<?php echo $carte['origine']; ?>">
							 <input type="hidden" name="nom" value="<?php echo $_GET['nom']; ?>">
							<input type="hidden" name="demande" value="<?php echo $carte['id']; ?>">
						
			<?php }else if($carte['protection']=='Ouvert sur critère' AND $accept['acceptation']!='oui'){	// TEST PR LE PROTECTION
			
					if($carte['pro_dep'] AND !$carte['pro_origine'] AND !$carte['pro_age']){
						if($carte['departement'] != $_SESSION['departement']){ ?>
							<form class="form-horizontal" method="post" action="demande.php">
							
								<input type="hidden" name="region" value="<?php echo $carte['departement']; ?>"> 
								<input type="hidden" name="sexe" value="<?php echo $carte['sexe']; ?>"> 
								<input type="hidden" name="origine" value="<?php echo $carte['origine']; ?>">
								 <input type="hidden" name="nom" value="<?php echo $_GET['nom']; ?>">
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
						
							<input type="hidden" name="region" value="<?php echo $carte['departement']; ?>">
							<input type="hidden" name="sexe" value="<?php echo $carte['sexe']; ?>"> 
							<input type="hidden" name="origine" value="<?php echo $carte['origine']; ?>">
							<input type="hidden" name="nom" value="<?php echo $_GET['nom']; ?>">
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
						
							<input type="hidden" name="region" value="<?php echo $carte['departement']; ?>"> 
							<input type="hidden" name="sexe" value="<?php echo $carte['sexe']; ?>"> 
							<input type="hidden" name="origine" value="<?php echo $carte['origine']; ?>">
							 <input type="hidden" name="nom" value="<?php echo $_GET['nom']; ?>">
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
						
							<input type="hidden" name="region" value="<?php echo $carte['departement']; ?>"> 
							<input type="hidden" name="sexe" value="<?php echo $carte['sexe']; ?>"> 
							<input type="hidden" name="origine" value="<?php echo $carte['origine']; ?>">
							 <input type="hidden" name="nom" value="<?php echo $_GET['nom']; ?>">
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
						
							<input type="hidden" name="region" value="<?php echo $carte['departement']; ?>"> 
							<input type="hidden" name="sexe" value="<?php echo $carte['sexe']; ?>"> 
							<input type="hidden" name="origine" value="<?php echo $carte['origine']; ?>">
							 <input type="hidden" name="nom" value="<?php echo $_GET['nom']; ?>">
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
			
					}if($carte['pro_origine'] AND $carte['pro_age']){
						if(($carte['origine'] != $_SESSION['origine']) AND ($carte['age_min'] >= $_SESSION['age'] OR $carte['age_max'] <= $_SESSION['age'])){ ?>
						<form class="form-horizontal" method="post" action="demande.php">
						
							<input type="hidden" name="region" value="<?php echo $carte['departement']; ?>"> 
							<input type="hidden" name="sexe" value="<?php echo $carte['sexe']; ?>"> 
							<input type="hidden" name="origine" value="<?php echo $carte['origine']; ?>">
							 <input type="hidden" name="nom" value="<?php echo $_GET['nom']; ?>">
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
						
							<input type="hidden" name="region" value="<?php echo $carte['departement']; ?>"> 
							<input type="hidden" name="sexe" value="<?php echo $carte['sexe']; ?>"> 
							<input type="hidden" name="origine" value="<?php echo $carte['origine']; ?>">
							 <input type="hidden" name="nom" value="<?php echo $_GET['nom']; ?>">
							<input type="hidden" name="demande" value="<?php $carte['id']; ?>"> 
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
										
										  <h4><?php echo htmlspecialchars($carte['nom']).' / '.$carte['sexe']; ?></h4>
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
										
										
										
 <?php	
			
			if(!empty($carte['protection'])){ 
		 
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
				</div>
				
				<div class="col-md-1 column">
				
				</div>
				
				<?php	}	//ferme la boucle	
		
			} 	// $_POST[cherche]
		}	// isset$_POST[cherche]				
?>

				</div>
			</div>
		</div>
	</section>
		
		
	<nav class="navbar navbar-fixed-bottom" role="navigation">
		<div class="container">
			<footer id="footer" class="text-center">
				<center><p>Copyright © 2023 Fooye Indus. All rights reserved.</p></center>
			</footer>
		</div>
	</nav>

<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>  
<script type="text/javascript" src="js/main.js"></script>

	</body>
</html>