<?php session_start(); 
try { 
		if(!isset($_SESSION['conect'])  && empty($_SESSION['conect'])){
			header("Location: index.php");
			die(); 
		}
			
		$bdd = new PDO('mysql:host=localhost;dbname=meet', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		
		if($_SESSION['id'] != $_GET['profil']){
		
		$reponse=$bdd->prepare('SELECT* FROM droit WHERE id_demandeur= ? AND id_demander= ?');
		$reponse->execute(array($_SESSION['id'], $_GET['profil']));
		$droit = $reponse->fetch();
		
			if(!$droit['id']){
				header("Location: index.php");
			}
		}
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
    <meta name="description" content="Profil">
    <meta name="author" content="Fooye Industrie">
    <title>Fooye - Meet</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet"> 
    <link href="css/main.css" rel="stylesheet">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="style.css"/>
   
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
<br><br><br><br><br>

<?php	
		
		if($_GET['profil'] == $_SESSION['id']){
		
			if($_SESSION['sexe']=='homme'){
				$re=$bdd->prepare('SELECT SUM(vue) AS max FROM vue WHERE id_vue=?');
				$re->execute(array($_SESSION['id']));
				$total_vue_homme = $re->fetch();
			}
			else{
				$re=$bdd->prepare('SELECT SUM(vue) AS max FROM vue WHERE id_vue=?');
				$re->execute(array($_SESSION['id']));
				$total_vue_femme = $re->fetch();
			}
				
			?>
			
		 <div class="container"><!--DEBUT CARTE DE VISITE  POUR LA PERSONNE CONECTER-->
		 
		 <?php
			$reponse=$bdd->prepare('SELECT* FROM carte WHERE id= ? ');
			$reponse->execute(array($_SESSION['id']));
			$carte = $reponse->fetch();
			
			if($_SESSION['sexe']=='femme'){
				$req = $bdd->prepare('SELECT*, DATE_FORMAT(date_demande, \'%d/%m à %Hh%imin\') AS date_demande FROM demande_femme WHERE id_femme = ? AND acceptation="" ORDER BY demande_femme.date_demande DESC LIMIT 6');
				$req->execute(array($_SESSION['id']));
				
				$rep=$bdd->prepare('SELECT COUNT(id_femme) AS max FROM demande_femme WHERE id_femme = ? AND acceptation != "oui" AND acceptation != "non" '); //compte le nombre de demande
				$rep->execute(array($_SESSION['id']));
				$num_meuf = $rep->fetch();
			}
			else{
				
				if(isset($_POST['affiche_tout'])) $limit = 10;
				else $limit = 5;
			
				$req1 = $bdd->prepare('SELECT demande_femme.id, id_femme, id_homme, acceptation, date_acceptation, nom, 
										DATE_FORMAT(date_acceptation, \'%d/%m à %Hh%imin\') AS date_accepte FROM demande_femme INNER JOIN 
										carte ON demande_femme.id_femme = carte.id WHERE id_homme = ? ORDER BY demande_femme.date_acceptation DESC LIMIT '.$limit);
				$req1->execute(array($_SESSION['id']));	

				$rep1=$bdd->prepare('SELECT COUNT(id_homme) AS max FROM demande_femme WHERE id_homme = ? AND (acceptation = "oui" OR acceptation = "non") '); //compte le nombre de demande
				$rep1->execute(array($_SESSION['id']));
				$num_mec = $rep1->fetch();
			}
			
		?>
					<div class="col-md-3">
						<?php
						
							if($_SESSION['sexe'] == 'femme'){
								if($num_meuf['max'] != 0){
							?>	
								<div id="id_button">
								 <button id="button_demande" type="button" onclick="voir_demande()" class="btn btn-danger">Demande <?php echo '+'.$num_meuf['max'];?></button>
								 </div>
								 
								<span id="new_demande" style="display : none;" ><br />
								<?php 	
								while($demande = $req->fetch()){										
										
										if(!$demande['acceptation']){
										 ?>
											<strong><a href="profil.php?profil=<?php $carte['id'];  ?>" ><?php echo $demande['demande'].'<br />';	?></a></strong>
											
												<?php echo 'le '.$demande['date_demande'].'<br />'; ?>
												
											<form method="post" action="demande.php">Accepter 
											<input type="hidden" name="id_co" value="<?php echo $demande['id']; ?>">
											<input type="hidden" name="profil" value="<?php echo $_GET['profil']; ?>">
											<button type="submit" name="ouioui" value="oui" class="btn btn-success">Oui
											</button><button type="submit" name="nonnon" value="non" class="btn btn-danger">Non</button></form><br />
						<?php			}
								}
							?>
								</span>	<br><br>
									
							<?php }else{ ?>	 
								 
								 <button type="button" class="btn btn-primary">Aucune Demande</button><br><br>
							<?php }  ?>

							<div class="panel panel-primary">
							  <div class="panel-heading">
								<h3 class="panel-title">Information</h3>
							  </div>
							  <div class="panel-body">
								<font color="blue">Vous avez <?php if($total_vue_femme['max'])echo $total_vue_femme['max']; else echo '0'; ?> vue(s) sur votre profil</font>
							  </div>
							</div>
							
							
							<?php
							}
							else{ //MEC CONECTER
							
							?>	
								<div id="id_accepte">
								 <button id="button_accepte" type="button" onclick="voir_accepte()" class="btn btn-primary">Acceptation</button>
								 </div>
								 
								<span id="new_accepte" style="display : none;" ><br />
								<?php 	
								while($demande = $req1->fetch()){
								
										
										if($demande['acceptation']){
											
											
												$req3 = $bdd->prepare('UPDATE demande_femme SET sayer = \'oui\' WHERE id = ? ');
												$req3->execute(array($demande['id']));
											
											
												if($demande['acceptation'] == 'oui'){
													
													echo ' le '.$demande['date_accepte'].'<br />';		
													echo htmlspecialchars($demande['nom']).' a accepté votre demande'; ?>
											
													<form method="get" action="profil.php">
														<input type="hidden" name="profil" value="<?php echo $demande['id_femme']; ?>">
														<button type="submit"  class="btn btn-success">Voir le profil</button>
													</form><br />
												
							<?php				}
												else{
													echo ' le '.$demande['date_accepte'].'<br />';
													echo htmlspecialchars($demande['nom']). ' n\'a pas accepté votre demande.<br /><br />';
												}
											}
										}
											if(!isset($_POST['affiche_tout']) AND $num_mec['max'] > 5){
												
									?>						
													<form method="post" action="profil-<?php echo $_GET['profil']; ?>">
														<input type="hidden" name="affiche_tout" value="oui">
														<button type="submit"  class="btn btn-danger">Afficher plus</button>
													</form>
									<?php }
												?>			
												
								</span>	<br /><br />
									
									<div class="panel panel-primary">
									  <div class="panel-heading">
										<h3 class="panel-title">Information</h3>
									  </div>
									  <div class="panel-body">
										<font color="blue">Vous avez <?php if($total_vue_homme['max'])echo $total_vue_homme['max']; else echo '0'; ?> Vue(s) sur votre profil</font>
									  </div>
									</div>
									
							<?php	
							}?>
						
					
					</div>
						
						
				<div class="col-lg-8">
				
					<!-- ===== vCard Navigation ===== -->
					<div class="row w">
						<div class="col-md-4">
							<img class="img-responsive" src="images/icon.jpg" alt="">
							<ul class="nav nav-tabs nav-stacked" id="myTab">
							  <li class="active"><a href="#about">About</a></li>
							  <li><a href="#profile">Profile</a></li>
							  <li><a href="#contact">Contact</a></li>
							  <li><a href="#modifier">modifier</a></li>
							  <li><a href="#suprimer">suprimer</a></li>
							</ul>    			
						</div><!-- col-md-4 -->

					<!-- ===== vCard Content ===== -->
						<div class="col-md-8">
							<div class="tab-content">
							
							  <!-- ===== First Tab ===== -->
							  <div class="tab-pane active" id="about">
							  
								<div class="text-center"><h2><?php echo htmlspecialchars($carte['nom']); ?></h2></div>
								<div class="text-right"><h5><?php echo $carte['sexe']; ?></h5></div>
								<hr><br />
								
								
							  <div class="text-center"><h4>Description</h4></div>
							  <p >
							  <?php if($carte['description']) echo htmlspecialchars($carte['description']).'<br />'; else echo 'Non renseignier'; ?>
							  </p><hr><br />
							  
							  <div class="text-center"><h4>Occupation</h4></div>
							  <p >
							  <?php if($carte['occupation']) echo htmlspecialchars($carte['occupation']).'<br />'; else echo 'Non renseignier'; ?>
							  </p><hr>
						
							  </div><!-- tab about -->
							  
							  <!-- ===== Second Tab ===== -->
							  <div class="tab-pane" id="profile">
							  
								 <div class="text-center"> <h4>Région & Age</h4></div>
								<p class="sm">
									<grey>Région</grey> | <?php echo $carte['departement']; ?><br/>
									<grey>Age</grey> | <?php echo $carte['age']; ?> ans<br/>
								</p>
							  
								  <div class="text-center"><h4> Origine</h4></div>
								<p class="sm">
									<grey>Origine</grey> | <?php echo $carte['origine']; ?><br/>
									<grey>Pays</grey> | <?php if($carte['pays']) echo htmlspecialchars($carte['pays']).'<br />'; else echo 'Non renseignier';?><br/>
								</p>						
								
								<div class="text-center"><h4>Physique</h4></div>
								<p class="sm">
									<grey>Poids</grey> | <?php if($carte['poids']){ echo $carte['poids']; ?> kg<br/> <?php }else echo 'Non renseignier'; ?><br />
									<grey>Taille</grey> | <?php if($carte['taille']){ echo $carte['taille']; ?> cm<br/> <?php }else echo 'Non renseignier'; ?><br />
								</p>
								
							  </div><!-- Tab Profile -->
							  
							  
							  <!-- ===== Third Tab ===== -->
							  <div class="tab-pane" id="contact">
							  
						  <?php if($carte['facebook']){ ?> 
							  
							  
								<div class="text-center"><h4>Facebook <span class="fa fa-facebook-square"></span> </h4></div>
								  <hr>
								  <div class="row">
									  <div class="col-xs-6">
										  <p class="sm">
											<i class="icon-globe"></i> <?php echo htmlspecialchars($carte['facebook']); ?> <br/> 
										  </p>
									  </div><!-- col-xs-6 -->
								
								  </div><!-- row -->
								  
							<?php } 
								if($carte['snap']){ ?> 
								   
								  <div class="text-center"> <h4>Snapchat <span class="fa fa-camera"></span> </h4></div>
								  <hr>
								  <div class="row">
									  <div class="col-xs-6">
										  <p class="sm">
											 <?php echo htmlspecialchars($carte['snap']); ?> <br/>
										  </p>
									  </div><!-- col-xs-6 -->
								  </div><!-- row -->
								  
							<?php } 
								if($carte['insta']){ ?> 
								  
								<div class="text-center"> <h4>Instragram <span class="fa fa-instagram"></span> </h4></div>
								  <hr>
								  <div class="row">
									  <div class="col-xs-6">
										  <p class="sm">
											 <?php echo htmlspecialchars($carte['insta']); ?> <br/>
										  </p>
									  </div><!-- col-xs-6 -->
								  </div><!-- row -->
								  
							<?php } 
								if($carte['twitter']){ ?> 
								  
								   <div class="text-center"><h4>Twitter <span class="fa fa-twitter-square"></span> </h4></div>
								  <hr>
								  <div class="row">
									  <div class="col-xs-6">
										  <p class="sm">
											<i class="icon-facebook"></i> <?php echo htmlspecialchars($carte['twitter']); ?> <br/>
										  </p>
									  </div><!-- col-xs-6 -->
								  </div><!-- row -->
							
							<?php }  ?> 					
								  
							  </div><!-- Tab Contact -->
							  
							  
								<!-- ===== fourth Tab ===== -->
							  <div class="tab-pane" id="modifier">
							
							
		<div class="container">
			<div class="row clearfix">
				<div class="col-md-11 column">
					<div class="row clearfix">
					
					<form id="form" class="form-horizontal" method="post" action="code.php" onsubmit="return verifier(this);">
					
						<div class="col-md-2 column">
							
							
								<div class="form-group">
							  <label for="sel1">Age</label>
							  <select name="age" class="form-control" id="sel1" required="required">
								<option><?php echo $carte['age']; ?></option>
								<option>-18</option><option>18</option><option>19</option>
								<option>20</option><option>21</option><option>22</option>
								<option>23</option><option>24</option><option>25</option>
								<option>26</option><option>27</option><option>28</option>
								<option>29</option><option>30</option><option>+30</option>
							  </select>
							</div>
							
								 <div class="form-group">
							  <label for="sel1">Poid</label>
							  <select name="poids" class="form-control" id="sel1" required="required">
								<option><?php echo $carte['poids']; ?></option><option>-50</option>
								<option>50</option><option>55</option><option>60</option><option>65</option>
								<option>70</option><option>75</option><option>80</option><option>85</option>
								<option>90</option><option>95</option><option>100</option><option>+100</option>        
								</select>
							</div>
								
									 <div class="form-group">
							  <label for="sel1">Taille</label>
							  <select name="taille" class="form-control" id="sel1" required="required">
								<option><?php echo $carte['taille']; ?></option><option>-140</option>
								<option>140</option><option>145</option><option>150</option><option>155</option>
								<option>160</option><option>165</option><option>170</option><option>175</option>
								<option>180</option><option>185</option><option>190</option><option>195</option>
								<option>200</option><option>+2OO</option>        
							 </select>
							 </div>
						
							<div class="form-group">
								<label for="InputMessage">Occupation</label>
								<div class="input-group">
									<textarea name="occupation" id="InputMessage" class="form-control" placeholder="Emploi et Scolarité" rows="2"><?php echo htmlspecialchars($carte['occupation']); ?></textarea>
									<span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
								</div>
							</div>
							
							<div class="form-group">
								<label for="InputMessage">Description</label>
								<div class="input-group">
									<textarea name="description" id="InputMessage" class="form-control" placeholder="Entre une description" rows="4"><?php echo htmlspecialchars($carte['description']); ?></textarea>
									<span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
								</div>
							</div>
						
						</div>
							
						<div class="col-md-1 column">	
								
						</div>
					
						<div class="col-md-2 column">	
						
							<div class="form-group">
								<label for="InputName">Facebook</label>
								<div class="input-group">
									<input type="text" class="form-control" name="fb" id="facebook" placeholder="Entre ton Facebook" value="<?php echo htmlspecialchars($carte['facebook']); ?>">
									<span class="input-group-addon"><span class="fa fa-facebook"></span></span>
								</div>
							</div>
							<div class="form-group">
								<label for="InputName">Instagram</label>
								<div class="input-group">
									<input type="text" class="form-control" name="insta" id="insta" placeholder="Entre ton Instagram" value="<?php echo htmlspecialchars($carte['insta']); ?>">
									<span class="input-group-addon"><span class="fa fa-camera-retro"></span></span>
								</div>
							</div>
							<div class="form-group">
								<label for="InputName">Snapchat</label>
								<div class="input-group">
									<input type="text" class="form-control" name="snap" id="snap" placeholder="Entre ton Snapchat" value="<?php echo htmlspecialchars($carte['snap']); ?>">
									<span class="input-group-addon"><span class="fa fa-camera"></span></span>
								</div>
							</div>
							<div class="form-group">
								<label for="InputName">Twitter</label>
								<div class="input-group">
									<input type="text" class="form-control" name="twitter" id="twitter" placeholder="Entre ton Twitter" value="<?php echo htmlspecialchars($carte['twitter']); ?>">
									<span class="input-group-addon"><span class="fa fa-twitter"></span></span>
								</div>
								<span id="reseaux" style="display : none;" >Renseigner au moins deux reseaux</span>
							</div> <br />



							<div class="text-center"><input type="submit" name="modifier" id="submit" value="Modifier" class="btn btn-warning"></div>
						</div>
					
					</form>
					
					</div>
				</div>
			</div>
		</div>
							
							  </div><!-- Tab Contact -->
							  
							  <!-- ===== Fifth Tab ===== -->
							  <div class="tab-pane" id="suprimer">
								<div class="text-center"><br /><br />
								
									<p>Cliqué sur continuer pour lancer la procédure de supression du profil.
									</p>
									
								</div>
								
								
										<div class="text-center">
										<input type="submit" name="valider" value="Continuer" onclick="valider();" class="btn btn-warning">
										</div>	
								
								
						
									<span id="supr" style="display : none;" >
									
										<div class="text-center"><br /><br />
											<p> Vous suprimerais définitivement votre profil, vous serais ensuite deconécté puis rediregé vers la page principale </p>
										</div>
									
										<form method="post" action="code.php">
											<div class="text-center">
												<input type="submit" name="suprimer" value="Suprimer" class="btn btn-danger">
											</div>	
										</form>
									
									</span>
											
							  </div><!-- Tab Contact -->
							  
												  
							</div><!-- Tab Content -->
						</div><!-- col-md-8 -->
					</div><!-- row w -->
				</div><!-- col-lg-6 -->
			
			</div><!-- /.container --> <!--FIN DE CARTE DE VISITE -->
			
<?php } 
		else{
			
		$reponse=$bdd->prepare('SELECT* FROM carte WHERE id= ? ');
		$reponse->execute(array($_GET['profil']));
		$carte = $reponse->fetch();
		
		if($carte['sexe']=='homme'){	//CALCULL TOTAL VUE
			$re=$bdd->prepare('SELECT SUM(vue) AS max FROM vue WHERE id_co=? AND id_vue=?');
			$re->execute(array($_SESSION['id'], $carte['id']));
			$total_vue = $re->fetch();
		}
		else{
			$re=$bdd->prepare('SELECT SUM(vue) AS max FROM vue WHERE id_co=? AND id_vue=?');
			$re->execute(array($_SESSION['id'], $carte['id']));
			$total_vue = $re->fetch();
		}
		
		
		if(isset($_GET['profil'])){
		
		//TEST POUR LE NOMBRE DE VUEE
		
		if($_SESSION['sexe']=='homme'){ //HOMME CONECTER
		
			$rep=$bdd->prepare('SELECT* FROM vue WHERE id_vue=? AND id_co=?');
			$rep->execute(array($_GET['profil'], $_SESSION['id']));
			$vue = $rep->fetch();
			
			if(!$vue['vue']){
				$date_vue=time();
				$date_final=time() + 86400;
				$req2 = $bdd->prepare('INSERT INTO vue (sexe_co, id_vue, sexe_vue, id_co, vue, date_debut, date_fin) VALUES(?, ?, ?, ?, "1", ?, ?)');
				$req2->execute(array($_SESSION['sexe'], $_GET['profil'], $carte['sexe'], $_SESSION['id'], $date_vue, $date_final));
			}
			else{			
				$temps_now =time();
				if($temps_now > $vue['date_fin']){
					$plus1 = $vue['vue'] + 1;
					$req3 = $bdd->prepare('UPDATE vue SET vue = ? WHERE id = ? ');
					$req3->execute(array($plus1, $vue['id']));
					
					//86400 secondes = 1 jour
					$date_debut=time();
					$plus_date = $date_debut + 86400 ; 
					$req = $bdd->prepare('UPDATE vue SET date_fin = ? WHERE id = ? ');
					$req->execute(array($plus_date, $vue['id']));
				}
			}	
			
			
			
		}
		else{	//FEMME CONECTER
			
			$rep=$bdd->prepare('SELECT* FROM vue WHERE id_co=? AND id_vue=?');
			$rep->execute(array($_SESSION['id'], $_GET['profil']));
			$vue = $rep->fetch();
			
			if(!$vue['vue']){
				$date_vue=time();
				$date_final=time() + 86400;
				$req2 = $bdd->prepare('INSERT INTO vue (sexe_co, id_co, sexe_vue, id_vue, vue, date_debut, date_fin) VALUES(?, ?, ?, ?, "1", ?, ?)');
				$req2->execute(array($_SESSION['sexe'], $_SESSION['id'], $carte['sexe'], $_GET['profil'], $date_vue, $date_final));
			}
			else{
				$temps_now =time();
				if($temps_now > $vue['date_fin']){
					$plus1 = $vue['vue'] + 1;
					$req3 = $bdd->prepare('UPDATE vue SET vue = ? WHERE id = ? ');
					$req3->execute(array($plus1, $vue['id']));
					
					//86400 seconde = 1 jours
					$date_debut=time();
					$plus_date = $date_debut + 86400 ;  
					$req = $bdd->prepare('UPDATE vue SET date_fin = ? WHERE id = ? ');
					$req->execute(array($plus_date, $vue['id']));
				}
			}
		}
		//TEST POUR LE NOMBRE DE VUEE
?>
		
		<div class="container"><!--DEBUT CARTE DE VISITE-->
    	

		<div class="col-lg-2">
		
			
			<div class="panel panel-primary">
			  <div class="panel-heading">
				<h3 class="panel-title">Information</h3>
			  </div>
			  <div class="panel-body">
				<font color="blue"><?php echo $total_vue['max']; ?> Visite(s) sur ce profil</font>
			  </div>
			</div>
			
			
		</div>
		
		<div class="col-lg-9">
    	
    		<!-- ===== vCard Navigation ===== -->
    		<div class="row w">
    			<div class="col-md-4">
    				<img class="img-responsive" src="images/icon.jpg" alt="">
					<ul class="nav nav-tabs nav-stacked" id="myTab">
					  <li class="active"><a href="#about">About</a></li>
					  <li><a href="#profile">Profile</a></li>
					  <li><a href="#contact">Contact</a></li>
					</ul>    			
				</div><!-- col-md-4 -->

    		<!-- ===== vCard Content ===== -->
    			 <div class="col-md-8"> 
	    			<div class="tab-content">
	    			
	    			  <!-- ===== First Tab ===== -->
					  <div class="tab-pane active" id="about">
					  	<div class="text-center"><h2><?php echo htmlspecialchars($carte['nom']); ?></h2></div>
					  	<div class="text-right"><h5><?php echo $carte['sexe']; ?></h5></div>
					  	<hr><br />
						
					  	<div class="text-center"><h4>Description</h4></div>
					  <p >
					  <?php if($carte['description']) echo htmlspecialchars($carte['description']).'<br />'; else echo 'Non renseignier'; ?>
					  </p><br />
					  
					  <div class="text-center"><h4>Occupation</h4></div>
					  <p >
					  <?php if($carte['occupation']) echo htmlspecialchars($carte['occupation']).'<br />'; else echo 'Non renseignier'; ?>
					  </p>
					  </div><!-- tab about -->
					  
	    			  <!-- ===== Second Tab ===== -->
					  <div class="tab-pane" id="profile">
					 
						  <div class="text-center"> <h4>Région & Age</h4></div>
					  	<p class="sm">
					  		<grey>Région</grey> | <?php echo $carte['departement']; ?><br/>
					  		<grey>Age</grey> | <?php echo $carte['age']; ?> ans<br/>
					  	</p>
						
						  <div class="text-center"><h4> Origine</h4></div>
					  	<p class="sm">
					  		<grey>Origine</grey> | <?php echo $carte['origine']; ?><br/>
					  		<grey>Pays</grey> | <?php if($carte['pays']) echo htmlspecialchars($carte['pays']).'<br />'; else echo 'Non renseignier';?><br/>
					  	</p>						
						
						  <div class="text-center"><h4>Physique</h4></div>
					  	<p class="sm">
					  		<grey>Poids</grey> | <?php if($carte['poids']){ echo $carte['poids']; ?> kg<br/> <?php }else echo 'Non renseignier'; ?><br />
					  		<grey>Taille</grey> | <?php if($carte['taille']){ echo $carte['taille']; ?> cm<br/> <?php }else echo 'Non renseignier'; ?><br />
					  	</p>		
					  	
					  </div><!-- Tab Profile -->
					  
					  
	    			  <!-- ===== Third Tab ===== -->
					  <div class="tab-pane" id="contact">
					  
					<?php if($carte['facebook']){ ?> 
					  
						  <div class="text-center"><h4>Facebook <span class="fa fa-facebook-square"></span> </h4></div>
						  <hr>
						  <div class="row">
							  <div class="col-xs-6">
								  <p class="sm">
								  	<?php echo htmlspecialchars($carte['facebook']); ?> 
								  </p>
							  </div><!-- col-xs-6 -->
						
						  </div><!-- row -->
						  
					<?php } 
						if($carte['snap']){ ?> 
						   
						  <div class="text-center"> <h4>Snapchat <span class="fa fa-camera"></span> </h4></div>
						  <hr>
						  <div class="row">
							  <div class="col-xs-6">
								  <p class="sm">
								  	 <?php echo htmlspecialchars($carte['snap']); ?>
								  </p>
							  </div><!-- col-xs-6 -->
						  </div><!-- row -->
						  
					<?php } 
						if($carte['insta']){ ?> 
						  
						   <div class="text-center"> <h4>Instragram <span class="fa fa-instagram"></span> </h4></div>
						  <hr>
						  <div class="row">
							  <div class="col-xs-6">
								  <p class="sm">
								  	<?php echo htmlspecialchars($carte['insta']); ?>
								  </p>
							  </div><!-- col-xs-6 -->
						  </div><!-- row -->
						  
					<?php } 
						if($carte['twitter']){ ?> 
						  
						    <div class="text-center"><h4>Twitter <span class="fa fa-twitter-square"></span> </h4></div>
						  <hr>
						  <div class="row">
							  <div class="col-xs-6">
								  <p class="sm">
								  	<?php echo htmlspecialchars($carte['twitter']); ?>
								  </p>
							  </div><!-- col-xs-6 -->
						  </div><!-- row -->
					
					<?php }  ?>
						  
						  
					  </div><!-- Tab Contact -->
					  
					</div><!-- Tab Content -->
    			</div><!-- col-md-8 -->
    		</div> <!--row w -->
    	</div> <!--col-lg-9 -->
		
		<div class="col-lg-1">
			<button type="button" class="btn btn-danger">Signaler</button>
		</div>
		
     </div><!--/.container -->

	 <!--FIN DE CARTE DE VISITE -->
		
		
<?php
		}
		else{	
				?>
		
		<br /><br />
			<div class="col-md-10 col-md-offset-1">
				<div class="panel panel-primary">
				  <div class="panel-heading">
					<h3 class="panel-title">Erreur !!</h3>
				  </div>
				  
				  <div class="panel-body"><div class="text-center">
				  <font color="blue">La Page demandé n'existe pas. <a href="index.php"><font color="black">Cliqué ici</font></a> pour aller à la page principale</font>
				  </div></div>
				  
				  
				</div>
			</div>
				
				<?php
		
		}
	}
?>


 <br><br><br><br><br>



<footer id="footer" class="text-center">
    <center><p>Copyright © 2023 Fooye Indus. All rights reserved.</p></center>
</footer>

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

	function verifier(f){

		var fb = document.getElementById("facebook").value;
		var insta = document.getElementById("insta").value;
		var snap = document.getElementById("snap").value;
		var twitter = document.getElementById("twitter").value;
		
		if((!fb && !insta && !snap) || (!twitter && !fb && !insta) || (!twitter && !fb && !snap) || (!twitter && !insta && !snap)){
			
			document.getElementById("reseaux").style.display = "inline";
			document.getElementById("reseaux").style.color = "red";
			document.getElementById("reseaux").style.fontWeight = "bold";
			return false;
		
		}
		else{
			document.getElementById("reseaux").style.display = "none";
			return true;
		}
	
	}	
	
	function valider(){
			
			document.getElementById("supr").style.display = "inline";
	}
	function voir_demande(){
			
			if(document.getElementById("new_demande").style.display == "inline"){
				document.getElementById("new_demande").style.display = "none"
			}
			else{
				document.getElementById("new_demande").style.display = "inline"
			}
		
	}

	function voir_accepte(){
			
			if(document.getElementById("new_accepte").style.display == "inline"){

				document.getElementById("new_accepte").style.display = "none"
			}
			else{
				document.getElementById("new_accepte").style.display = "inline"
			}
		
	}
// -->

</script>

</body>
</html>