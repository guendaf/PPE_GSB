<div id="global">   
    <div id="gauche">
        <article>
                <h1>Mes fiches de frais</h1>
                    <form action="index.php?uc=validerFrais&action=voirEtatFiche" method="post">
                      <div class="form_settings">
                          <fieldset class="cadre"><br/>
                              <legend>Visiteur et mois à sélectionner : </legend>
                                <label for="lstVisiteur" accesskey="n">Visiteur : </label>
                                <select id="lstVisiteur" name="lstVisiteur">
                                    <?php 
                                    foreach ($lesVisiteurs as $unVisiteur)
                                    { 
                                    $idVisiteur = $unVisiteur['idVisiteur'];
                                    $nomVisiteur = $unVisiteur['nom'];
                                    $prenomVisiteur = $unVisiteur['prenom'];
                                    if($idVisiteur == $visiteurASelectionner){
                                    ?>
                                    <option selected value="<?php echo $idVisiteur ?>"><?php echo $nomVisiteur." - ".$prenomVisiteur ?></option>
                                    <?php 
                                    }
                                    else{ ?>
                                    <option value="<?php echo $idVisiteur ?>"><?php echo $nomVisiteur." - ".$prenomVisiteur ?></option>
                                    <?php
                                    }
                                    }
                                    ?>
                                </select>
                                <span><label for="mois" accesskey="n">Mois : </label></span>
                                <input type="text" id="mois" name="mois" value="" placeholder="aaaamm"/>
                                <br/><br/>
                            </fieldset>
                          <input class="button" type="submit" value="Valider" />
                          <input class="button" type="reset" value="Effacer" />
                      </div>
                    </form><br/>
                
            </article>
            <br/>
