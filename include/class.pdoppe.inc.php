<?php

/** 
 * Classe d'accès aux données. 
 
 * Utilise les services de la classe PDO
 * pour l'application GSB
 * Les attributs sont tous statiques,
 * les 4 premiers pour la connexion
 * $monPdo de type PDO 
 * $monPdoGsb qui contiendra l'unique instance de la classe
 
 * @package default
 * @author GUENDAF Sofian
 * @version    1.0
 * @link       http://www.php.net/manual/fr/book.pdo.php
 */

class PdoPPE{
    
    private static $serveur='mysql:host=localhost';
    private static $bdd='dbname=gsbV2';
    private static $user='root';
    private static $mdp='';
            private static $monPdo;
            private static $monPdoPPE=NULL;
    
    
/**
 * Constructeur privé, crée l'instance de PDO qui sera sollicitée
 * pour toutes les méthodes de la classe
 */	
    private function __construct() {
        PdoPPE::$monPdo = new PDO(PdoPPE::$serveur .';'. PdoPPE::$bdd, PdoPPE::$user, PdoPPE::$mdp);
                PdoPPE::$monPdo->query("SET CHARACTER SET utf8");
    }
    
    public function __destruct() {
        PdoPPE::$monPdo = NULL;
    }
    
/**
 * Fonction statique qui crée l'unique instance de la classe
 
 * Appel : $instancePdoGsb = PdoGsb::getPdoGsb();
 
 * @return l'unique objet de la classe PdoGsb
 */
    public static function getPdoPPE(){
        if(PdoPPE::$monPdoPPE==NULL){
            PdoPPE::$monPdoPPE = new PdoPPE();
            return PdoPPE::$monPdoPPE;
        }
    }
    
    
/**
 * Retourne les infos d'un visiteur
 
 * @param $login 
 * @param $mdp
 
 * @return l'id, le nom et la profession sous forme de tableau associatif
 */    
    public function getInfosVisiteur($login, $mdp){
		$req = "select visiteur.id as id, visiteur.nom as nom, visiteur.prenom as prenom, visiteur.profession as profession from visiteur 
		where visiteur.login='$login' and visiteur.mdp='$mdp'";
		$rs = PdoPPE::$monPdo->query($req);
		$ligne = $rs->fetch();
		return $ligne;
	}
/**
 * retourne les mois pour lesquelles un visiteur a une fiche de frais
 * @param $idVisiteur
 * @return un tableau associatif de clé un mois -aaaamm- et de valeurs l'année et le mois correspondant 
 */
    public function getLesMoisDisponibles($idVisiteur){
		$req = "select fichefrais.mois as mois from  fichefrais where fichefrais.idvisiteur ='$idVisiteur' 
		order by fichefrais.mois desc ";
		$res = PdoPPE::$monPdo->query($req);
		$lesMois =array();
		$laLigne = $res->fetch();
		while($laLigne != null)	{
			$mois = $laLigne['mois'];
			$numAnnee =substr( $mois,0,4);
			$numMois =substr( $mois,4,2);
			$lesMois["$mois"]=array(
		     "mois"=>"$mois",
		    "numAnnee"  => "$numAnnee",
			"numMois"  => "$numMois");
			$laLigne = $res->fetch(); 		
		}
		return $lesMois;
    }
    
/**
 * retourne la liste de tous les visiteurs
 * @param $idVisiteur
 * @return le nom et le prénom de tous les visiteurs
 */
    public function getLesVisiteur($idVisiteur){
		$req = "select visiteur.id as idVisiteur, visiteur.nom as nom, visiteur.prenom as prenom
                from  visiteur where idVisiteur ='$idVisiteur' 
		order by visiteur.nom asc ";
		$res = PdoPPE::$monPdo->query($req);
		$lesVisiteurs =array();
		$laLigne = $res->fetch();
		while($laLigne != null)	{
			$idVisiteur = $laLigne['idVisiteur'];
			$nomVisiteur = $laLigne['nomVisiteur'];
			$prenomVisiteur = $laLigne['prenomVisiteur'];
			$lesVisiteurs["$idVisiteur"]=array(
                            "idVisiteur"=>"$idVisiteur",
                            "nomVisiteur"  => "$nomVisiteur",
                            "prenomVisiteur"  => "$prenomVisiteur");
			$laLigne = $res->fetch(); 		
		}
		return $lesVisiteurs;
    }

/**
 *  retourne les infos d'une fiche de frais d'un visiteur pour un mois donné
 * @param $idVisiteur
 * @param $mois
 * @return un tableau avec des champs de jointure entre une fiche de frais et la ligne d'état
 */
    public function getLesInfosFicheFrais($idVisiteur,$mois){
		$req = "select ficheFrais.idEtat as idEtat, ficheFrais.dateModif as dateModif, ficheFrais.nbJustificatifs as nbJustificatifs, 
			ficheFrais.montantValide as montantValide, etat.libelle as libEtat from  fichefrais inner join Etat on ficheFrais.idEtat = Etat.id 
			where fichefrais.idvisiteur ='$idVisiteur' and fichefrais.mois = '$mois'";
		$res = PdoPPE::$monPdo->query($req);
		$laLigne = $res->fetch();
		return $laLigne;
	}
    
/**
 * Retourne sous forme d'un tableau associatif toutes les lignes de frais au forfait
 * concernées par les deux arguments
 * @param $idVisiteur
 * @param $mois sous la forme aaaamm
 * @return l'id, le libelle et la quantité sous la forme d'un tableau associatif 
 */        
    public function getLesFraisForfait($idVisiteur, $mois){
		$req = "select fraisforfait.id as idfrais, fraisforfait.libelle as libelle, 
		lignefraisforfait.quantite as quantite, fraisforfait.image as image from lignefraisforfait inner join fraisforfait 
		on fraisforfait.id = lignefraisforfait.idfraisforfait
		where lignefraisforfait.idvisiteur ='$idVisiteur' and lignefraisforfait.mois='$mois' 
		order by lignefraisforfait.idfraisforfait";	
		$res = PdoPPE::$monPdo->query($req);
		$lesLignes = $res->fetchAll();
		return $lesLignes; 
	}
 
/**
 * Retourne sous forme d'un tableau associatif toutes les lignes de frais hors forfait
 * concernées par les deux arguments
 
 * La boucle foreach ne peut être utilisée ici car on procède
 * à une modification de la structure itérée - transformation du champ date-
 * 
 * @param $idVisiteur
 * @param $mois
 * @return tous les champs des lignes de frais hors forfait sous la forme d'un tableau associatif 
 */        
    public function getLesFraisHorsForfait($idVisiteur,$mois){
	    $req = "select * from lignefraishorsforfait where lignefraishorsforfait.idvisiteur ='$idVisiteur' 
		and lignefraishorsforfait.mois = '$mois' ";	
		$res = PdoPPE::$monPdo->query($req);
		$lesLignes = $res->fetchAll();
		$nbLignes = count($lesLignes);
		for ($i=0; $i<$nbLignes; $i++){
			$date = $lesLignes[$i]['date'];
			$lesLignes[$i]['date'] =  dateAnglaisVersFrancais($date);
		}
		return $lesLignes; 
	}
    
/**
 * Teste si un visiteur possède une fiche de frais pour le mois passé en argument
 
 * @param $idVisiteur
 * @param $mois
 * @return vrai ou faux
 */        
        public function estPremierFraisMois($idVisiteur,$mois)
	{
		$ok = false;
		$req = "select count(*) as nblignesfrais from fichefrais 
		where fichefrais.mois = '$mois' and fichefrais.idvisiteur = '$idVisiteur'";
		$res = PdoPPE::$monPdo->query($req);
		$laLigne = $res->fetch();
		if($laLigne['nblignesfrais'] == 0){
			$ok = true;
		}
		return $ok;
	}
/**
 * Retourne le dernier mois en cours d'un visiteur
 
 * @param $idVisiteur 
 * @return le mois sous la forme aaaamm
*/	
	public function dernierMoisSaisi($idVisiteur){
		$req = "select max(mois) as dernierMois from fichefrais where fichefrais.idvisiteur = '$idVisiteur'";
		$res = PdoPPE::$monPdo->query($req);
		$laLigne = $res->fetch();
		$dernierMois = $laLigne['dernierMois'];
		return $dernierMois;
	}
	
/**
 * Crée une nouvelle fiche de frais et les lignes de frais au forfait pour un visiteur et un mois donné
 
 * récupère le dernier mois en cours de traitement, met à 'CL' son champs idEtat, crée une nouvelle fiche de frais
 * avec un idEtat à 'CR' et crée les lignes de frais forfait de quantités nulles 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
*/
	public function creeNouvellesLignesFrais($idVisiteur,$mois){
		$dernierMois = $this->dernierMoisSaisi($idVisiteur);
		$laDerniereFiche = $this->getLesInfosFicheFrais($idVisiteur,$dernierMois);
		if($laDerniereFiche['idEtat']=='CR'){
				$this->majEtatFicheFrais($idVisiteur, $dernierMois,'CL');
				
		}
		$req = "insert into fichefrais(idvisiteur,mois,nbJustificatifs,montantValide,dateModif,idEtat) 
		values('$idVisiteur','$mois',0,0,now(),'CR')";
		PdoPPE::$monPdo->exec($req);
		$lesIdFrais = $this->getLesIdFrais();
		foreach($lesIdFrais as $uneLigneIdFrais){
			$unIdFrais = $uneLigneIdFrais['idfrais'];
			$req = "insert into lignefraisforfait(idvisiteur,mois,idFraisForfait,quantite) 
			values('$idVisiteur','$mois','$unIdFrais',0)";
			PdoPPE::$monPdo->exec($req);
		}
	}

/**
 * Crée une nouvelle fiche de frais et les lignes de frais au forfait pour un visiteur et ce pour le mois suivant
 * @param $idVisiteur
 * @param $mois
 */        
        public function creeNouvelleFiche($idVisiteur, $mois){
                $moisSuivant=moisSuivant($mois);
		$req = "insert into fichefrais(idvisiteur,mois,nbJustificatifs,montantValide,dateModif,idEtat) 
		values('$idVisiteur','$moisSuivant',0,0,now(),'CR')";
		PdoPPE::$monPdo->exec($req);
		$lesIdFrais = $this->getLesIdFrais();
		foreach($lesIdFrais as $uneLigneIdFrais){
			$unIdFrais = $uneLigneIdFrais['idfrais'];
			$req = "insert into lignefraisforfait(idvisiteur,mois,idFraisForfait,quantite) 
			values('$idVisiteur','$moisSuivant','$unIdFrais',0)";
			PdoPPE::$monPdo->exec($req);
		}
                
	}
        
/**
 * Test si une fiche de frais du mois suivant existe
 * @param $idVisiteur
 * @param $moisSuivant
 * @return vrai ou faux
 */ 
        public function ficheFraisExist($idVisiteur,$moisSuivant){
		$ok = false;
		$req = "select count(*) as nblignesfrais from fichefrais 
		where fichefrais.mois = '$moisSuivant' and fichefrais.idvisiteur = '$idVisiteur'";
		$res = PdoPPE::$monPdo->query($req);
		$laLigne = $res->fetch();
		if($laLigne['nblignesfrais'] != 0){
			$ok = true;
		}
		return $ok;
	}
        
/**
 * Ajoute les frais hors forfait refusé du mois courant d'un visiteur dans la table des frais hors forfait du mois suivant
 * @param type $idVisiteur
 * @param type $moisSuivant
 * @param type $libelle
 * @param type $dateHF
 * @param type $montantHF
 */
        public function ajouterFraisHorsForfaitMoisSuivant($idVisiteur,$moisSuivant,$libelle,$dateHF,$montantHF){
		$dateFr = dateFrancaisVersAnglais($dateHF);
		$req = "insert into lignefraishorsforfait 
		values('','$idVisiteur','$moisSuivant','REFUSE : $libelle','$dateFr','$montantHF')";
		PdoPPE::$monPdo->exec($req);
        }

/**
 * Retourne tous les id de la table FraisForfait
 * @return un tableau associatif 
 */
        public function getLesIdFrais(){
		$req = "select fraisforfait.id as idfrais from fraisforfait order by fraisforfait.id";
		$res = PdoPPE::$monPdo->query($req);
		$lesLignes = $res->fetchAll();
		return $lesLignes;
	}

/**
 * Modifie l'état et la date de modification d'une fiche de frais
 
 * Modifie le champ idEtat et met la date de modif à aujourd'hui
 * @param type $idVisiteur
 * @param type $mois
 * @param type $etat
 */
        public function majEtatFicheFrais($idVisiteur,$mois,$etat){
		$req = "update ficheFrais set idEtat = '$etat', dateModif = now() 
		where fichefrais.idvisiteur ='$idVisiteur' and fichefrais.mois = '$mois'";
		PdoPPE::$monPdo->exec($req);
	}

/**
 *Met à jour la table ligneFraisForfait
 
 * Met à jour la table ligneFraisForfait pour un visiteur et
 * un mois donné en enregistrant les nouveaux montants
 * 
 * @param type $idVisiteur
 * @param type $mois
 * @param type $lesFrais
 */
        public function majFraisForfait($idVisiteur, $mois, $lesFrais){
		$lesCles = array_keys($lesFrais);
		foreach($lesCles as $unIdFrais){
			$qte = $lesFrais[$unIdFrais];
			$req = "update lignefraisforfait set lignefraisforfait.quantite = $qte
			where lignefraisforfait.idvisiteur = '$idVisiteur' and lignefraisforfait.mois = '$mois'
			and lignefraisforfait.idfraisforfait = '$unIdFrais'";
			PdoPPE::$monPdo->exec($req);
		}
	}

/**
 * Supprime le frais hors forfait dont l'id est passé en argument
 * @param type $idFrais
 */
        public function supprimerFraisHorsForfait($idFrais){
		$req = "delete from lignefraishorsforfait where lignefraishorsforfait.id =$idFrais ";
		PdoPPE::$monPdo->exec($req);
	}

/**
 * Crée un nouveau frais hors forfait pour un visiteur et un mois donné
 * à partir des informations fournies en paramètre
 * @param type $idVisiteur
 * @param type $mois
 * @param type $libelle
 * @param type $date
 * @param type $montant
 */
        public function creeNouveauFraisHorsForfait($idVisiteur,$mois,$libelle,$date,$montant){
		$dateFr = dateFrancaisVersAnglais($date);
		$req = "insert into lignefraishorsforfait 
		values('','$idVisiteur','$mois','$libelle','$dateFr','$montant')";
		PdoPPE::$monPdo->exec($req);
	}
        
/**
 * retourne une liste de tous les inscrits sauf les comtables
 * @return un tableau associatif
 */
        public function getLesVisiteurs() {
              $req="select visiteur.id as idVisiteur, visiteur.nom as nom, visiteur.prenom as prenom from visiteur where profession != 'comptable'";
              $res= PdoPPE::$monPdo->query($req);
              $lesLignes = $res->fetchAll();
              return $lesLignes;
        }

/**
 * Met à jour la fiche de frais d'un visiteur pour un mois donné en modifiant 
 * le libellé d'un frais hors forfait passé en paramètre en ajoutant 
 * 'REFUSE :' en debut de texte 
 
 * @param type $idVisiteur
 * @param type $mois
 * @param type $idFrais
 * @param type $libelle
 */
        public function refuseFraisHorsForfait($idVisiteur,$mois, $idFrais, $libelle){
		$req = "update lignefraishorsforfait set lignefraishorsforfait.libelle = 'REFUSE : $libelle'
		where lignefraishorsforfait.idvisiteur ='$idVisiteur' and lignefraishorsforfait.mois = '$mois' and lignefraishorsforfait.id = '$idFrais'";
		PdoPPE::$monPdo->exec($req);
	}

 /**
  * Valide une fiche de frais
  
  * L'id de l'état passe à 'CL' et la dateModif devient la date actuel 
  * @param type $idVisiteur
  * @param type $mois
  */
        public function validerFicheFrais($idVisiteur,$mois){
		$req = "update ficheFrais set ficheFrais.idEtat = 'CL', ficheFrais.dateModif = now() 
		where ficheFrais.idvisiteur ='$idVisiteur' and ficheFrais.mois = '$mois'";
		PdoPPE::$monPdo->exec($req);
	}

/**
 * 
 * @return type
 */
        public function getFichesVisiteurs(){
            $req = "select ficheFrais.idVisiteur as idVisiteur, ficheFrais.mois as mois, ficheFrais.idEtat, visiteur.nom as nomV, visiteur.prenom as prenomV
                   from ficheFrais join visiteur on ficheFrais.idVisiteur = visiteur.id
                   where idEtat = 'CL'
                   order by mois desc ";
            $res = PdoPPE::$monPdo->query($req);
            $lesLignes = $res->fetchAll();
            return $lesLignes;
        }

/**
 * retourne les informations d'une fiche pour un visiteur et un mois donné dont l'id de l'état est 'CL'
 * @param $idVisiteur
 * @param $mois
 * @return un tableau associatif
 */
        public function getLaFicheVisiteur($idVisiteur, $mois){
		$req = "select ficheFrais.idVisiteur as idVisiteur, ficheFrais.mois as mois , 
                    ficheFrais.nbJustificatifs as nb, ficheFrais.MontantValide as montant,
                    ficheFrais.dateModif as dateModif, ficheFrais.idEtat as idEtat, etat.libelle as libelle
                   from ficheFrais join etat on ficheFrais.idEtat = etat.id
                   where idVisiteur = '$idVisiteur' and mois ='$mois' and idEtat = 'CL'";
		$res = PdoPPE::$monPdo->query($req);
		$laLigne = $res->fetch();
		
		return $laLigne;
        }
}
?>