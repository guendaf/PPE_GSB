<?php
// Si aucune action n'est défini, l'action par défault sera : demandeConnexion
// Cela permettra d'afficher une page connexion.php dans laquelle l'utilisateur 
// saisira son login et mdp afin de pouvoir se connecter.
if(!isset($_REQUEST['action'])){
	$_REQUEST['action'] = 'demandeConnexion';
}
$action = $_REQUEST['action'];
switch($action){
	case 'demandeConnexion':{
		include("vue/v_connexion.php");
		break;
	}
	case 'valideConnexion':{
            // l'utilisateur saisi son login/mdp, le système les compare avec 
            // les données login/mdp de la table visiteur en BDD afin de vérifier si 
            //l'utilisateur existe bien dans la BDD.
                $login = $_REQUEST['login'];
                $mdp = $_REQUEST['mdp'];
                $visiteur= $pdo->getInfosVisiteur($login, $mdp);
                if(!is_array($visiteur)){
                    // le login ou mdp est inconnu, un message d'erreur s'affiche
                    ajouterErreur("Login ou mot de passe incorrect");
                    include("vue/v_erreur.php");
                    include("vue/v_connexion.php");
                }
                else{
                    //le login et mdp est correct, le système assigne les infos 
                    //de base à des variables afin de les rendre global à toutes 
                    //les pages du site à travers la fonction connecter.
                    $id = $visiteur['id'];
                    $nom =  $visiteur['nom'];
                    $prenom = $visiteur['prenom'];
                    $profession = $visiteur['profession'];
                    connecter($id,$nom,$prenom,$profession);
                    
                    //Si l'utilisateur est un comptable, le systême affichera le 
                    //sommaire dédié à ce dernier afin de lui permettre le suivi 
                    //et la validation d'une fiche de frais. 
                    //Si l'utilisateur est un visiteur, le sommaire lui permmettra 
                    //la saisi et le suivi d'une fiche de frais
                    if($profession=='comptable'){
                        include("vue/v_sommaireC.php");
                    }
                    else{
                        include("vue/v_sommaireV.php");
                    } 
                }
                break;
        }
                
	default :{
		include("vue/v_connexion.php");
		break;
	}
}
?>