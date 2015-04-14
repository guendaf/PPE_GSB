<?php

$action = $_REQUEST['action'];

switch ($action){
    case 'selectionnerFicheValide':{
            $lesFiches=$pdo->getFichesVisiteurs();
            include("vue/v_listeFicheValide.php");
            echo '</div>';
            include("vue/v_sommaireC.php");
            break;
    }
    
    case 'voirEtatFicheValide':{
            $lesFiches=$pdo->getFichesVisiteurs();
            $res = explode(":", $_REQUEST['lstFiche']);
            $idVisiteur = $res[0];
            $mois = $res[1];
            conserverId($idVisiteur,$mois);
            $laFicheFrais = $pdo->getLaFicheVisiteur($idVisiteur, $mois);
            $libelleEtat=$laFicheFrais['libelle'];
            $nbJustificatifs =$laFicheFrais['nb'];
            $montant=$laFicheFrais['montant'];
            $dateModif=$laFicheFrais['dateModif'];
            $LesFraisForfait=$pdo->getLesFraisForfait($idVisiteur, $mois);
            $LesFraisHorsForfait=$pdo->getLesFraisHorsForfait($idVisiteur, $mois);
            include("vue/v_listeFicheValide.php");
            include("vue/v_etatFicheValide.php");
            include("vue/v_sommaireC.php");
            break;
    }
    
    case 'miseEnPaiement':{
            $lesFiches=$pdo->getFichesVisiteurs();
            $idVisiteur = $_SESSION['idVisiteur'];
            $mois = $_SESSION['mois'];
            $laFicheFrais = $pdo->getLaFicheVisiteur($idVisiteur, $mois);
            $libelleEtat='mise en paiment';
            $nbJustificatifs =$laFicheFrais['nb'];
            $montant=$laFicheFrais['montant'];
            $dateModif=$laFicheFrais['dateModif'];
            $LesFraisForfait=$pdo->getLesFraisForfait($idVisiteur, $mois);
            $LesFraisHorsForfait=$pdo->getLesFraisHorsForfait($idVisiteur, $mois);
            include("vue/v_listeFicheValide.php");
            include("vue/v_etatFicheValide.php");
            include("vue/v_sommaireC.php");
            break;
    }
}
?>