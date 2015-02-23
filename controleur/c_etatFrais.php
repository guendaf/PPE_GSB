<?php
$action = $_REQUEST['action'];
$idVisiteur = $_SESSION['id'];
switch ($action){
    case 'selectionnerMois':{
        $lesMois=$pdo->getLesMoisDisponibles($idVisiteur);
		// Afin de sélectionner par défaut le dernier mois dans la zone de liste
		// on demande toutes les clés, et on prend la première,
		// les mois étant triés décroissants
		$lesCles = array_keys( $lesMois );
		$moisASelectionner = $lesCles[0];
                include("vue/v_listeMois.php");
                echo '</div>';
                include("vue/v_sommaireV.php");
                break;
    }
    case 'voirEtatFrais':{
                $leMois = $_REQUEST['lstMois']; 
		$lesMois=$pdo->getLesMoisDisponibles($idVisiteur);
		$moisASelectionner = $leMois;
		include("vue/v_listeMois.php");
                //Afin de permettre l'affichage d'une fiche de frais, on y extrait 
                //les données necessaires que l'on assigne à des variables 
                //sous forme de chaine de caractère ou bien de tableaux. 
		$lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur,$leMois);
		$lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur,$leMois);
		$lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($idVisiteur,$leMois);
                // on extrait l'année et le mois afin de les afficher séparément 
                // dans la vue.
		$numAnnee =substr( $leMois,0,4);
		$numMois =substr( $leMois,4,2);
		$libEtat = $lesInfosFicheFrais['libEtat'];
		$montantValide = $lesInfosFicheFrais['montantValide'];
		$nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
		$dateModif =  $lesInfosFicheFrais['dateModif'];
		$dateModif =  dateAnglaisVersFrancais($dateModif);
		include("vue/v_etatFrais.php");
        
                include("vue/v_sommaireV.php");
        
            break;
    }
    
}
?>