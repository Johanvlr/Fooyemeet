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
	
	if(isset($_POST['submit'])){ 
									
		$rep=$bdd->prepare('SELECT LTRIM(?) AS blk');
		$rep->execute(array($_POST['nom']));
		$don = $rep->fetch();
		
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
		
		$reponse6=$bdd->prepare('SELECT LTRIM(?) AS mdp');
		$reponse6->execute(array($_POST['mdp2']));
		$donnees6 = $reponse6->fetch();
		
		$req = $bdd->prepare('SELECT email FROM carte WHERE email = ?');
		$req->execute(array($_POST['email']));
		$exist = $req->fetch();
				
		
		if($_POST['sexe'] == 'homme'){ //HOMME
		
			if(!$don['blk'] OR ($_POST['mdp'] != $_POST['mdp2']) OR $exist['email'] OR (!$donnees2['fb'] 
				AND !$donnees3['insta'] AND !$donnees4['snap'] AND !$donnees5['twitter']) OR !$donnees6['mdp']
				OR !$_POST['age'] OR !$_POST['origine']){		
				
						
					header('Location: sign.php');
			
			}
			else{ 

			// TOUT SE PASSE ICI --> AJOUT A LA BDD
					  $hache=sha1(htmlspecialchars($_POST['mdp2']));
			
						$req = $bdd->prepare('INSERT INTO carte (nom, sexe, departement, origine, age,  email, password, facebook, insta, snap, twitter)
						VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
						$req->execute(array(htmlspecialchars($_POST['nom']), $_POST['sexe'], $_POST['departement'], $_POST['origine'], $_POST['age'],
											htmlspecialchars($_POST['email']), $hache, htmlspecialchars($_POST['fb']), htmlspecialchars($_POST['insta']),
											htmlspecialchars($_POST['snap']), htmlspecialchars($_POST['twitter'])));
											
						$_SESSION['conect']=on;
						$_SESSION['email']=$_POST['email'];
		
						header('Location: index.php');	
			}
		
			
			
		}else{ //FEMME
		
			if(!$don['blk'] OR ($_POST['mdp'] != $_POST['mdp2']) OR $exist['email'] OR (!$donnees2['fb'] 
				AND !$donnees3['insta'] AND !$donnees4['snap'] AND !$donnees5['twitter']) OR !$donnees6['mdp']
				OR !$_POST['age'] OR !$_POST['origine'] OR !$_POST['protection']){		
				
						header('Location: sign.php');
					
			}
			
			else{ 

			// TOUT SE PASSE ICI --> AJOUT A LA BDD
			
				$hache=sha1($_POST['mdp2']);
	
				$req = $bdd->prepare('INSERT INTO carte (nom, sexe, departement, origine, age,  email, password, facebook, insta, snap, twitter)
				VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
				$req->execute(array($_POST['nom'], $_POST['sexe'], $_POST['departement'], $_POST['origine'], $_POST['age'],
									$_POST['email'], $hache, $_POST['fb'], $_POST['insta'], $_POST['snap'], $_POST['twitter']));
									
				$id=$bdd->prepare('SELECT id FROM carte WHERE email=?');
				$id->execute(array($_POST['email']));
				$id_femme = $id->fetch();
				
				
					$req2 = $bdd->prepare('INSERT INTO inscri_femme (id_femme, protection) VALUES(?, ?)');
					$req2->execute(array($id_femme['id'], $_POST['protection']));
					
					if($_POST['protection'] == 'Ouvert sur critère'){
					
						if(isset($_POST['choix1']) AND !empty($_POST['choix1'])){
							$req3 = $bdd->prepare('UPDATE inscri_femme SET pro_dep = ? WHERE id_femme = ? ');
							$req3->execute(array($_POST['choix1'], $id_femme['id']));
						}
						if(isset($_POST['choix2']) AND !empty($_POST['choix2'])){
							$req4 = $bdd->prepare('UPDATE inscri_femme SET pro_origine = ? WHERE id_femme = ? ');
							$req4->execute(array($_POST['choix2'], $id_femme['id']));
						}
						if(isset($_POST['choix3']) AND !empty($_POST['choix3'])){
							$req5 = $bdd->prepare('UPDATE inscri_femme SET pro_age = ?, age_min = ?, age_max = ? WHERE id_femme = ?');
							$req5->execute(array($_POST['choix3'], $_POST['age_min'], $_POST['age_max'], $id_femme['id']));
						}
					}
					
				$_SESSION['conect']=on;
				$_SESSION['email']=$_POST['email'];

				header('Location: index.php');
				
			}
		}
		
		
												
	}
	

?>
