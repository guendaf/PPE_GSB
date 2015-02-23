<div id="droit"> 
        <section>
            <h1>VISITEUR</h1>
            Bonjour <?php echo $_SESSION['prenom']."  ".$_SESSION['nom']  ?><br/>
            <ul>
                <li><a href="index.php?uc=etatFrais&action=selectionnerMois">Mes fiches de frais</a></li>
                <li><a href="index.php?uc=gererFrais&action=saisirFraisForfait">Saisie fiche de frais</a></li>
                <li><a href="index.php?uc=connexion&action=demandeConnexion">Déconnexion</a></li>
            </ul>
        </section>
</div>

