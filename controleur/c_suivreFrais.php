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
           
            $idVisiteur='a131';
            $mois='201503';
            
            $laFicheFrais = $pdo->getLesFichesVisiteur($idVisiteur, $mois);
            
            $LesFraisForfait=$pdo->getLesFraisForfait($idVisiteur, $mois);
            $LesFraisHorsForfait=$pdo->getLesFraisHorsForfait($idVisiteur, $mois);
            include("vue/v_listeFicheValide.php");
            include("vue/v_etatFicheValide.php");
            include("vue/v_sommaireC.php");
            break;
    }

}
?>