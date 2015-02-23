<?php

$action = $_REQUEST['action'];

switch ($action){
    case 'selectionnerFiche':{
        $lesVisiteurs = $pdo->getLesVisiteurs();
        $lesCles = array_keys($lesVisiteurs);
        $visiteurASelectionner = $lesCles[0];
        include("vue/v_listeFiche.php");
        echo '</div>';
        include("vue/v_sommaireC.php");
            break;
    }
    case 'voirEtatFiche':{
        
        $idVisiteur = $_REQUEST['lstVisiteur'];
        $mois = $_REQUEST['mois'];
        $lesVisiteurs = $pdo->getLesVisiteurs();
        conserverId($idVisiteur,$mois);
        
        $lesVisiteursFiches=$pdo->getLesInfosFicheFrais($idVisiteur,$mois);
        
        
        if ($mois==""){
            ajouterErreur("Vous devez choisir un mois");
                include("vue/v_erreur.php");
                include("vue/v_listeFiche.php");
                echo '</div>';
                include("vue/v_sommaireC.php");
        }
        
        else if(!is_array( $lesVisiteursFiches )){   
            ajouterErreur("Pas de fiche de frais pour ce visiteur ce mois");
                include("vue/v_erreur.php");
                include("vue/v_listeFiche.php");
                echo '</div>';
                include("vue/v_sommaireC.php");
        }
        else{
            $lesInfosFicheFrais=$pdo->getLesInfosFicheFrais($idVisiteur,$mois);
            $dateModif=$lesInfosFicheFrais['dateModif'];
            $libEtat=$lesInfosFicheFrais['libEtat'];
            $montant=$lesInfosFicheFrais['montantValide'];
        
            $LesFraisForfait=$pdo->getLesFraisForfait($idVisiteur, $mois);
            $LesFraisHorsForfait=$pdo->getLesFraisHorsForfait($idVisiteur, $mois);
        
            include("vue/v_listeFiche.php");
            include("vue/v_etapeFiche.php");
            include("vue/v_sommaireC.php");
        }
            break;
    }
    case 'validerFiche':{
        $idVisiteur = $_SESSION['idVisiteur'];
        $mois = $_SESSION['mois'];
        $lesVisiteurs = $pdo->getLesVisiteurs();
        
        $lesInfosFicheFrais=$pdo->getLesInfosFicheFrais($idVisiteur,$mois);
        $dateModif=$lesInfosFicheFrais['dateModif'];
        $libEtat=$lesInfosFicheFrais['libEtat'];
        $montant=$lesInfosFicheFrais['montantValide'];
        
        $LesFraisForfait=$pdo->getLesFraisForfait($idVisiteur, $mois);
        $LesFraisHorsForfait=$pdo->getLesFraisHorsForfait($idVisiteur, $mois);
        
        $pdo->validerFicheFrais($idVisiteur,$mois);
        
        include("vue/v_listeFiche.php");
        include("vue/v_etapeFiche.php");
        include("vue/v_sommaireC.php");
            break;
    }
    
    case 'actualiserFicheFrais':{
        $idVisiteur = $_SESSION['idVisiteur'];
        $mois = $_SESSION['mois'];
        
        $lesVisiteurs = $pdo->getLesVisiteurs();
        
        $lesInfosFicheFrais=$pdo->getLesInfosFicheFrais($idVisiteur,$mois);
        $dateModif=$lesInfosFicheFrais['dateModif'];
        $libEtat=$lesInfosFicheFrais['libEtat'];
        $montant=$lesInfosFicheFrais['montantValide'];
        
        $lesFrais = $_REQUEST['lesFrais'];

        if(lesQteFraisValides($lesFrais)){
            $pdo->majFraisForfait($idVisiteur,$mois,$lesFrais);
            alert("Mise à jour validé");
            }
            else{
            ajouterErreur("Les valeurs des frais doivent être numériques");
            include("vue/v_erreur.php");
            }
        

        $LesFraisForfait=$pdo->getLesFraisForfait($idVisiteur, $mois);
        $LesFraisHorsForfait=$pdo->getLesFraisHorsForfait($idVisiteur, $mois);
        
        include("vue/v_listeFiche.php");
        include("vue/v_etapeFiche.php");
        include("vue/v_sommaireC.php");
            break;
    }
    case 'supprimerFicheFrais':{
        $idVisiteur = $_SESSION['idVisiteur'];
        $mois = $_SESSION['mois'];
        
        $lesVisiteurs = $pdo->getLesVisiteurs();
        
        $lesInfosFicheFrais=$pdo->getLesInfosFicheFrais($idVisiteur,$mois);
        $dateModif=$lesInfosFicheFrais['dateModif'];
        $libEtat=$lesInfosFicheFrais['libEtat'];
        $montant=$lesInfosFicheFrais['montantValide'];
        
        
        $idFrais = $_REQUEST['id'];
        $libelle= $_REQUEST['libelle'];
        $montantHF= $_REQUEST['montantHF'];
        $dateHF= $_REQUEST['dateHF'];
        
        $pdo->refuseFraisHorsForfait($idVisiteur,$mois, $idFrais, $libelle);

        $moisSuivant=moisSuivant($mois);
        
        if($pdo->ficheFraisExist($idVisiteur,$moisSuivant)==false){
        $pdo->creeNouvelleFiche($idVisiteur, $mois);
        }
        $libelle=tronquerTexte($libelle);
        $pdo->ajouterFraisHorsForfaitMoisSuivant($idVisiteur,$moisSuivant,$libelle,$dateHF,$montantHF);
        $pdo->supprimerFraisHorsForfait($idFrais);
        
        $LesFraisForfait=$pdo->getLesFraisForfait($idVisiteur, $mois);
        $LesFraisHorsForfait=$pdo->getLesFraisHorsForfait($idVisiteur, $mois);
        
        include("vue/v_listeFiche.php");
        include("vue/v_etapeFiche.php");
        include("vue/v_sommaireC.php");
            break;
    }
}
?>