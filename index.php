<?php
require_once("include/fct.inc.php");
require_once("include/class.pdoppe.inc.php");
include("vue/v_entete.php");
session_start();
$pdo = PdoPPE::getPdoPPE();
$estConnecte = estConnecte();
if(!isset($_REQUEST['uc']) || !$estConnecte){
    $_REQUEST['uc'] = 'connexion';
}
$uc = $_REQUEST['uc'];
switch ($uc){
    case 'connexion':{
        include("controleur/c_connexion.php");
            break;
    }
    case 'etatFrais':{
        include("controleur/c_etatFrais.php");
            break;
    }
    case 'gererFrais':{
        include("controleur/c_gererFrais.php");
            break;
    }
    case 'validerFrais':{
        include("controleur/c_validerFrais.php");
            break;
    }
    case 'suivreFrais':{
        include("controleur/c_suivreFrais.php");
            break;
    }
}
include("vue/v_pied.php");
?>

