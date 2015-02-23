<div id="droit"> 
        <section>
            <h1><?php echo $_SESSION['fonction'] ?></h1>
            Bonjour <?php echo $_SESSION['prenom']."  ".$_SESSION['nom']  ?><br/>
            <ul>
                <li><a href="index.php?uc=validerFrais&action=selectionnerFiche">Valider fiche de frais</a></li>
                <li><a href="index.php?uc=suivreFrais&action=selectionnerFicheValide">Suivre le paiement</a></li>
                <li><a href="index.php?uc=connexion&action=demandeConnexion">Déconnexion</a></li>
            </ul>
        </section>
    </div>