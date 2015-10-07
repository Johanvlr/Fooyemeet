<?php

	if(isset($_POST['email']) && !empty($_POST['email'])){
		$email = htmlspecialchars($_POST['email']);
		try
		{
			$bdd = new PDO('mysql:host=localhost;dbname=meet', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		}
		catch(Exception $e)
		{
				die('Erreur : '.$e->getMessage());
		}
		
			$req = $bdd->prepare('SELECT email FROM carte WHERE email = ?');
			$req->execute(array($email));
			$exist = $req->fetch();
			
			if($exist['email']){  //Email Existant
				echo 1;
			}
			
			else echo 0;
			
	}
	else{
		
		echo -1;
	
	}
	
?>