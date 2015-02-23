<div id="global">   
    <div id="gauche">
        <article>
            <h1>Suivre le paiement</h1>
                <form action="index.php?uc=suivreFrais&action=voirEtatFicheValide" method="post">
                    <div class="form_settings">
                        <fieldset class="cadre"><br/>
                        <legend>Fiche à sélectionner : </legend>
                          <label for="lstFiche" accesskey="n">Fiches : </label>
                            <select id="lstFiche" name="lstFiche">
                                <?php 
                                foreach($lesFiches as $uneFiche){
                                    
                                        $idV = $uneFiche['idVisiteur'];      
                                        $nomV = $uneFiche['nomV'];  
                                        $prenomV = $uneFiche['prenomV']; 
                                        $mois = $uneFiche['mois'];
                                        $numAnnee = substr($mois, 0,4);
                                        $numMois = substr($mois, 4,2);
                                        $mois=$numMois."/".$numAnnee;
                                ?>
                                <option  value="<?php echo $idV?>"><?php echo $nomV ." ".$prenomV." - ". $mois ?></option>
                                <?php
                                }
                                ?>
                            </select>
                          <br/><br/>
                        </fieldset>     
                        <input class="button" type="submit" value="Valider" />
                        <input class="button" type="reset" value="Effacer" />
                    </div>
                </form><br/>
        </article> 