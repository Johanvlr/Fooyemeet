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
	
	if($_SESSION['sexe'] == 'femme'){ 
					
		if(isset($_POST['ouioui'])){
		
			//LA PERSONNE A LE DROIT DE VOIR LE PROFIL
			$req3 = $bdd->prepare('INSERT INTO droit(id_demandeur, id_demander) VALUES (?, ?) ');
			$req3->execute(array($_POST['id_co'], $_POST['profil']));
			//LA PERSONNE A LE DROIT DE VOIR LE PROFIL
			
			$req3 = $bdd->prepare('UPDATE demande_femme SET acceptation = ?, date_acceptation= NOW() WHERE id = ? ');
			$req3->execute(array($_POST['ouioui'], $_POST['id_co']));
			$url='profil-'.$_POST["profil"];
			header('Location: '.$url);
		}
		if(isset($_POST['nonnon'])){
	
			$req3 = $bdd->prepare('UPDATE demande_femme SET acceptation = ?, date_acceptation= NOW() WHERE id = ? ');
			$req3->execute(array($_POST['nonnon'], $_POST['id_co']));
			$url='profil-'.$_POST["profil"];
			header('Location: '.$url);
		}
	}
	
	
		if(isset($_POST['demande'])){
		
			
			$req1 = $bdd->prepare('SELECT * FROM demande_femme WHERE id_homme = ? AND id_femme= ? ');
			$req1->execute(array($_SESSION['id'],$_POST['demande']));	
			$accept=$req1->fetch();
			
			if($accept['id']){
				if(!isset($_POST['nom'])){
						$url='index-'.$_POST["region"].'-'.$_POST["sexe"].'-'.$_POST["origine"].'-'.$_POST['page'];
						header('Location: '.$url);
				}
				else{
					$url='chercher-'.$_POST["nom"];
					header('Location: '.$url);
				}
				exit;
			}
			else{
			
				$demande = $_SESSION['pseudo'].' amerais acceder à votre profil';
				$req2 = $bdd->prepare('INSERT INTO demande_femme (id_femme, id_homme, demande, date_demande) VALUES(?, ?, ?, NOW())');
				$req2->execute(array($_POST['demande'], $_SESSION['id'], htmlspecialchars($demande)));
				
				if(!isset($_POST['nom'])){
					$url='index-'.$_POST["region"].'-'.$_POST["sexe"].'-'.$_POST["origine"].'-'.$_POST['page'];
					header('Location: '.$url);
				}
				else{
					$url='chercher-'.$_POST["nom"];
					header('Location: '.$url);
				}
			}
		}
	
?>