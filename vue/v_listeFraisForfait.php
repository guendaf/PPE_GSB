<div id="global">
<div id="gauche">
        <article>
            <h1>Renseigner ma fiche de frais du mois 12 - 2014</h1>
            <form method="POST"  action="index.php?uc=gererFrais&action=miseAJourFraisForfait">
                <div class="form_settings">
                    <fieldset class="cadre">
                      <legend>Eléments forfaitisés</legend></br>
                      <?php 
                        foreach ($lesFraisForfait as $unFraisForfait)
                        {
                            $image = $unFraisForfait['image'];
                            $idFrais = $unFraisForfait['idfrais'];
                            $libelle = $unFraisForfait['libelle'];
                            $quantite = $unFraisForfait['quantite'];
                      ?>
                      
                      <img src="<?php echo $image ?>"/><span><label for="idFrais"><?php echo $libelle ?> : 
                          </label></span><input id="idFrais" type="text" 
                                name="lesFrais[<?php echo $idFrais?>]" value="<?php echo $quantite ?>" size="30" maxlength="45"/></br></br>
                    <?php
                    }
                    ?>
                    </fieldset>
                    
                <input class="button" type="submit" name="valider" value="Valider" />
                </div>
            </form>
            
            
            
                
            </br></br>
            </article>