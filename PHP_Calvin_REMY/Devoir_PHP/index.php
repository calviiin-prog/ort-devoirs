<?php

(isset($_COOKIE['infoUser'])) ? $infoUser = $_COOKIE['infoUser'] : $infoUser = "";

require_once("modele/Bdd.php");
require_once("modele/Requetes.php");
$connexionBDD = new Requetes(new Bdd());
require_once('controller/Controller.php');
$controller = new Controller();

(isset($_POST['connexionUser'])) ? $formUserLogin = $_POST['connexionUser'] : $formUserLogin = "";

if($formUserLogin !== ""){
	$controller->homeModele($_POST['connexionUser'], $_POST['nomUser'], $_POST['mdpUser'], $connexionBDD);
}
if ($infoUser === ""){
	$erreur = 0;

	if ($formUserLogin !== ""){
		$erreur = 1;
	}
	$controller->homeView($erreur);
} else {
	
	$infoUser = unserialize(urldecode($infoUser));

	$controller->headView();
	$controller->navView($infoUser, intval($infoUser['level']));

	(isset($_GET['page'])) ? $page = $_GET['page'] : $page = "";


	if ($page === "" || $page === "voirTacheEnCours" || $page === "voirTacheTerminee"){
		
		$statut = 0;
		if ($page === "voirTacheEnCours"){
			$statut = 1;
		} else if ($page === "voirTacheTerminee"){
			$statut = 2;
		}
		
		$controller->tacheModele(intval($infoUser['id']), $connexionBDD, $statut);


	} else if ($page === "ajoutTache"){
		
		(isset($_POST['ajoutTache'])) ? $formAjoutTacheBDD = $_POST['ajoutTache'] : $formAjoutTacheBDD = "";

		if ($formAjoutTacheBDD !== ""){
			
			$controller->ajoutTacheModele($_POST['nomTache'], intval($infoUser['id']), $connexionBDD);
		}
		$controller->ajoutTacheView();
	} else if ($page === "updateTache"){
		
		$controller->updateTacheModele($_POST['numeroTache'], intval($infoUser['id']), $_POST['newNameTache'], $_POST['newStatut'], $connexionBDD);

	} else if ($page === "deleteTache"){
	
		$controller->deleteTacheModele($_POST['numeroTache'], intval($infoUser['id']), $connexionBDD);

	} else if ($page === "voirUser"){

		$controller->userController(intval($infoUser['id']), intval($infoUser['level']), $connexionBDD);

	} else if ($page === "ajoutUser"){

		(isset($_POST['ajoutUser'])) ? $formAjoutUserBDD = $_POST['ajoutUser'] : $formAjoutUserBDD = "";

		if ($formAjoutUserBDD !== ""){
			$controller->ajoutUserModele(intval($infoUser['id']), intval($infoUser['level']), $_POST['nomUser'], $_POST['prenomUser'], $_POST['emailUser'], $_POST['mdpUser'], $_POST['levelUser'], $connexionBDD);
		}
		
		$controller->ajoutUser(intval($infoUser['level']));

	} else if ($page ===  "updateUser"){
		
		$controller->updateUserModele(intval($infoUser['level']), $_POST['idUser'], $_POST['newNomUser'], $_POST['newPrenomUser'], $_POST['newEmailUser'], $_POST['newMdpUser'], $_POST['newlevel'], $connexionBDD);
	} else if ($page === "deleteUser"){
		
		$controller->deleteUserModele(intval($infoUser['level']), $_POST['idUser'], $connexionBDD);
	} else if ($page === "deconnexion"){
		
		$controller->deconnexion();
	} else {
		

		$controller->erreurView();
	}

	$controller->scriptView();
}
?>