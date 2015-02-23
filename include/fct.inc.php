<?php


    function estConnecte(){
       return isset($_SESSION['id']);
    }
    
    
    function connecter($idVisiteur, $nom, $prenom, $fonction){
        $_SESSION['id'] = $idVisiteur;
        $_SESSION['nom'] = $nom;
        $_SESSION['prenom'] = $prenom;
        $_SESSION['fonction'] = $fonction;
    }
    
    function conserverId($idVisiteur,$mois){
	$_SESSION['idVisiteur']= $idVisiteur; 
        $_SESSION['mois']= $mois;
    }
    
    function ajouterErreur($msg){
        if (! isset($_REQUEST['erreurs'])){
        $_REQUEST['erreurs']=array();
	} 
        $_REQUEST['erreurs'][]=$msg;
    }
    
    function dateAnglaisVersFrancais($maDate){
        @list($annee,$mois,$jour)=explode('-',$maDate);
        $date="$jour"."/".$mois."/".$annee;
    return $date;
    }
    
    function getMois($date){
		@list($jour,$mois,$annee) = explode('/',$date);
		if(strlen($mois) == 1){
			$mois = "0".$mois;
		}
		return $annee.$mois;
    }

    function estEntierPositif($valeur) {
	return preg_match("/[^0-9]/", $valeur) == 0;
	
}

    function estTableauEntiers($tabEntiers) {
	$ok = true;
	foreach($tabEntiers as $unEntier){
		if(!estEntierPositif($unEntier)){
		 	$ok=false; 
		}
	}
	return $ok;
    }
    
    function lesQteFraisValides($lesFrais){
            return estTableauEntiers($lesFrais);
    }
    
    function dateFrancaisVersAnglais($maDate){
	@list($jour,$mois,$annee) = explode('/',$maDate);
	return date('Y-m-d',mktime(0,0,0,$mois,$jour,$annee));
    }
    
    function nbErreurs(){
    if (!isset($_REQUEST['erreurs'])){
	   return 0;
	}
	else{
	   return count($_REQUEST['erreurs']);
	}
    }

    function valideInfosFrais($dateFrais,$libelle,$montant){
	if($dateFrais==""){
		ajouterErreur("Le champ date ne doit pas être vide");
	}
	else{
		if(!estDatevalide($dateFrais)){
			ajouterErreur("Date invalide");
		}	
		else{
			if(estDateDepassee($dateFrais)){
				ajouterErreur("date d'enregistrement du frais dépassé, plus de 1 an");
			}			
		}
	}
	if($libelle == ""){
		ajouterErreur("Le champ description ne peut pas être vide");
	}
	if($montant == ""){
		ajouterErreur("Le champ montant ne peut pas être vide");
	}
	else
		if( !is_numeric($montant) ){
			ajouterErreur("Le champ montant doit être numérique");
		}
}

function estDateValide($date){
	$tabDate = explode('/',$date);
	$dateOK = true;
	if (count($tabDate) != 3) {
	    $dateOK = false;
    }
    else {
		if (!estTableauEntiers($tabDate)) {
			$dateOK = false;
		}
		else {
			if (!checkdate($tabDate[1], $tabDate[0], $tabDate[2])) {
				$dateOK = false;
			}
		}
    }
	return $dateOK;
}

function estDateDepassee($dateTestee){
	$dateActuelle=date("d/m/Y");
	@list($jour,$mois,$annee) = explode('/',$dateActuelle);
	$annee--;
	$AnPasse = $annee.$mois.$jour;
	@list($jourTeste,$moisTeste,$anneeTeste) = explode('/',$dateTestee);
	return ($anneeTeste.$moisTeste.$jourTeste < $AnPasse); 
}

function alert($string){
        echo '<script type="text/javascript">alert("' . $string . '");</script>';
}

function moisSuivant($mois){
     $numMois=  substr($mois, 4,2);
     $numAnne= substr($mois, 0,4);
     if($numMois<9){
        $numMois = '0'.strval(intval($numMois)+1); 
     }
     elseif($numMois>=9 && $numMois<12){
        $numMois = strval(intval($numMois)+1); 
     }
     else{
        $numMois = '01';
        $numAnne++;
     }
     $moisSuivant = $numAnne.$numMois;
     return $moisSuivant;
     }
     
function tronquerTexte($libelle){
     $lgMax = 30;
     if (strlen($libelle) > $lgMax)
     {
        $libelle = substr($libelle, 0, $lgMax);
        $lastSpace = strrpos($libelle, " ");
        $libelle = substr($libelle, 0, $lastSpace)."...";
}
    return $libelle;
}
?>