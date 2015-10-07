<?php session_start(); 
try { 
		if (!isset($_SESSION['conect']) && empty($_SESSION['conect'])){
			header("Location: index.php");
			die(); 
		}
	
		$bdd = new PDO('mysql:host=localhost;dbname=meet', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	}
	
catch(Exception $e) {

		die('Erreur : '.$e->getMessage()); 
 } 

if(isset($_GET['origine']) AND isset($_GET['page'])){

		header('location: index-'.$_GET["region"].'-'.$_GET["sexe"].'-'.$_GET["origine"].'-'.$_GET["page"]);
		
}

if(isset($_GET['profil'])){

		header('location: profil-'.$_GET["profil"]);
		
}
	
	if(isset($_GET['nom'])){
		if(isset($_GET['nom']) AND !empty($_GET['nom'])){
	
			header('Location: chercher-'.$_GET['nom']);
		}
		else	header('location: index.php');
	}

	
if(isset($_POST['modifier'])){
	if($_POST['modifier']){

		$reponse2=$bdd->prepare('SELECT LTRIM(?) AS fb');
		$reponse2->execute(array($_POST['fb']));
		$donnees2 = $reponse2->fetch();
		
		$reponse3=$bdd->prepare('SELECT LTRIM(?) AS insta');
		$reponse3->execute(array($_POST['insta']));
		$donnees3 = $reponse3->fetch();
		
		$reponse4=$bdd->prepare('SELECT LTRIM(?) AS snap');
		$reponse4->execute(array($_POST['snap']));
		$donnees4 = $reponse4->fetch();
		
		$reponse5=$bdd->prepare('SELECT LTRIM(?) AS twitter');
		$reponse5->execute(array($_POST['twitter']));
		$donnees5 = $reponse5->fetch();
		
		$reponse6=$bdd->prepare('SELECT LTRIM(?) AS descr');
		$reponse6->execute(array($_POST['description']));
		$donnees6 = $reponse6->fetch();
		
		$reponse7=$bdd->prepare('SELECT LTRIM(?) AS occup');
		$reponse7->execute(array($_POST['occupation']));
		$donnees7 = $reponse7->fetch();
		
		if(!$donnees2['fb'] AND !$donnees3['insta'] AND !$donnees4['snap'] AND !$donnees5['twitter']){		
			
			$url='profil-'.$_SESSION['id'];	
			header('Location: '.$url);
		
		}
		else{
							
			$req = $bdd->prepare('UPDATE carte SET age = :nvage, poids = :nvpoids, taille= :nvtaille, description= :nvdescr, 
								occupation= :nvocup, facebook= :nvfb, insta= :nvinsta, snap= :nvsnap, twitter= :nvtwitter WHERE email = :email');
		
			$req->execute(array(
				'nvage' => $_POST['age'],
				'nvpoids' => $_POST['poids'],
				'nvtaille' => $_POST['taille'],
				'nvdescr' => $donnees6['descr'],
				'nvocup' => $donnees7['occup'],
				'nvfb' => $donnees2['fb'],
				'nvinsta' => $donnees3['insta'],
				'nvsnap' => $donnees4['snap'],
				'nvtwitter' => $donnees5['twitter'],
				'email' => $_SESSION['email'],
				));
				
			$url='profil-'.$_SESSION['id'];	
			header('Location: '.$url);
			
		}
	}
}

if(isset($_POST['suprimer'])){
	if($_POST['suprimer']){

		$req = $bdd->prepare('DELETE FROM carte WHERE email = :email');
		$req->execute(array('email' => $_SESSION['email']));
		
		session_destroy();
		
			header('Location: index.php');
	}
}

?>