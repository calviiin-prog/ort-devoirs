<?php

class Controller {
	
	public function headView(){
		include('views/htmlHead.php');
	}
	
	public function scriptView(){
		include('views/htmlScript.php');
	}

	public function navView($infoUser, $level){
		include('views/nav.php');
		echo "<div class=\"sousNav\"></div>";
	}

	public function homeView($erreur){
		include('views/login.php');
	}

	public function homeModele($formValid = "", $nom = "", $pwd = "", $connexionBDD){

		$validation = htmlentities($formValid, ENT_QUOTES);
		if ($validation !== "" && $validation === "Valider"){
			$nomUser = htmlentities($nom, ENT_QUOTES);
			$mdpUser = htmlentities($pwd, ENT_QUOTES);

			if ($nomUser !== "" && $mdpUser !== ""){
				$verifUser = $connexionBDD->verifUser($nomUser, $mdpUser);

				if ($verifUser){
					foreach ($verifUser as $value) {
						$idUser = $value["id_user"];
						$nomUser = $value["nom_user"];
						$prenomUser = $value["prenom_user"];
						$emailUser = $value["email_user"];
						$mdpUser = $value["mdp_user"];
						$levelUser = $value["level_user"];

						$tabUserInfo['id'] = $idUser;
						$tabUserInfo['nom'] = $nomUser;
						$tabUserInfo['prenom'] = $prenomUser;
						$tabUserInfo['email'] = $emailUser;
						$tabUserInfo['mdp'] = $mdpUser;
						$tabUserInfo['level'] = $levelUser;
					}
					$tabUserInfo = urlencode(serialize($tabUserInfo));
					setcookie("infoUser", $tabUserInfo, time() + 172800, '/');

					echo "<script language=\"JavaScript\">
					setTimeout(\"window.location='http://devoirphp/'\",0);
					</script>";
					exit();
				} else {
					return false;
				}

			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	public function tacheModele($idUser, $connexionBDD, $statut = 0){
		switch ($statut) {
			case 1:
			$titre = "Liste des taches en cours";
			$titreVide = "Il n'y a aucune tache en cours";
			$valueInput = "Ajouter une tache";
			$hrefInput = "ajoutTache";
			break;
			
			case 2:
			$titre = "Liste des taches terminées";
			$titreVide = "Il n'y a aucune tache terminée";
			$valueInput = "Visualiser toutes les taches";
			$hrefInput = "";
			break;
			
			default:
			$titre = "Liste des taches";
			$titreVide = "Il n'y a aucune tache";
			$valueInput = "Ajouter une tache";
			$hrefInput = "ajoutTache";
			break;
		}

		$recupTache = $connexionBDD->recupTache($idUser, $statut);

		self::tacheView($recupTache, $titre, $titreVide, $valueInput, $hrefInput);
	}

	public function tacheView($donneesRecup, $titre, $titreVide, $valueInput, $hrefInput){

		if (empty($donneesRecup)){

			include('views/tacheVide.php');
		} else {

			include('views/listeTaches.php');
		}
	}

	public function ajoutTacheView(){

		include('views/ajoutTaches.php');
	}
	
	public function ajoutTacheModele($nomTache, $idUser, $connexionBDD){
	
		$connexionBDD->ajoutTache($idUser, $nomTache);
		
		self::tacheModele($idUser, $connexionBDD);
	}

	public function updateTacheModele($idTache, $idUser, $nom, $newStatut = 0, $connexionBDD){
		
		$connexionBDD->updateTache($idTache, $idUser, $nom, $newStatut);

		self::tacheModele($idUser, $connexionBDD, $newStatut);
	}

	public function deleteTacheModele($idTache, $idUser, $connexionBDD){
		
		$connexionBDD->deleteTache($idTache, $idUser);
		self::tacheModele($idUser, $connexionBDD);
	}
	
	public function userController($idUser, $level, $connexionBDD){
		
		$donneesRecup = $connexionBDD->recupUser($idUser, $level);
		
		self::userView($donneesRecup);
	}

	public function ajoutUserModele($idUser, $levelUser, $nom, $prenom, $email, $mdp, $level, $connexionBDD){
		
		$connexionBDD->ajoutUser($nom, $prenom, $email, $mdp, $level);
	
		self::userController($idUser, $levelUser, $connexionBDD);
	}

	public function ajoutUser($level){
		if ($level !== 1){
			return false;
		} else {
			include('views/ajoutUser.php');
		}
	}

	public function userView($donneesRecup){
		$titre = "Liste des utilisateurs";
	
		include('views/listeUser.php');
	}

	public function updateUserModele($levelUser, $idUser, $nom, $prenom, $email, $mdp, $level, $connexionBDD){
		
		$connexionBDD->updateUser($idUser, $nom, $prenom, $email, $mdp, $level);

		self::userController($idUser, $levelUser, $connexionBDD);
	}

	public function deleteUserModele($levelUser, $idUser, $connexionBDD){

		$connexionBDD->deleteUser($idUser);
	
		self::userController($idUser, $levelUser, $connexionBDD);
	}

	public function erreurView(){
	
		include('views/erreur.php');
	}

	public function deconnexion(){
		
		setcookie("infoUser", "", time() - 172800, '/');
		unset($_COOKIE["infoUser"]);
		
		echo "<script language=\"JavaScript\">
		setTimeout(\"window.location='http://devoirphp/'\",0);
		</script>";
		exit();
	}


}
