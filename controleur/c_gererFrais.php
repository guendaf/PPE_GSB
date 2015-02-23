<?php
$idVisiteur = $_SESSION['id'];
$mois = getMois(date("d/m/Y"));
$numAnnee= substr($mois, 0,4);
$numMois= substr($mois, 4,2);
$action = $_REQUEST['action'];

switch ($action){
    case 'saisirFraisForfait':{
            //Lorsque le visiteur demande a saisir une fiche de frais, si la fiche 
            //de frais n'existe pas et qu'il s'agit d'une première saisie, le systême
            // créer une nouvelle fiche de frais avec les frais forfait initialisé à
            //0 ainsi qu'un tableau des éléments hors forfait vide. 
            if($pdo->estPremierFraisMois($idVisiteur,$mois)){
                $pdo->creeNouvellesLignesFrais($idVisiteur,$mois);
            }
            break;
    }
    case 'miseAJourFraisForfait':{
            $lesFrais = $_REQUEST['lesFrais'];
            //Le système vérifie si les données saisies sont de type numérique,
            //dans ce cas, les données sont mis à jour.
            if(lesQteFraisValides($lesFrais)){
                $pdo->majFraisForfait($idVisiteur,$mois,$lesFrais);
            }
            else{
                ajouterErreur("Les valeurs des frais doivent être numériques");
                include("vue/v_erreur.php");
            }
            break;
    }
    case 'validerCreationFrais':{
            $dateFrais = $_REQUEST['dateFrais'];
            $libelle = $_REQUEST['libelle'];
            $montant = $_REQUEST['montant'];
            valideInfosFrais($dateFrais,$libelle,$montant);
            if (nbErreurs() != 0 ){
                include("vue/v_erreur.php");
            }
            else{
                $pdo->creeNouveauFraisHorsForfait($idVisiteur,$mois,$libelle,$dateFrais,$montant);
            }
            break;
    }
    case 'supprimerFrais':{
            $idFrais = $_REQUEST['idFrais'];
	    $pdo->supprimerFraisHorsForfait($idFrais);
            break;
    }
}
$lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur,$mois);
$lesFraisForfait= $pdo->getLesFraisForfait($idVisiteur,$mois);
include("vue/v_listeFraisForfait.php");
include("vue/v_listeFraisHorsForfait.php");
include("vue/v_sommaireV.php");
?>