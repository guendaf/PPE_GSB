<div id="global">   
    <div id="gauche">
        <article>
            <h1>Mes fiches de frais</h1>
                <form action="index.php?uc=etatFrais&action=voirEtatFrais" method="post">
                  <div class="form_settings">
                      <fieldset class="cadre"><br/>
                        <legend>Mois à sélectionner : </legend>
                      <label for="lstMois" accesskey="n">Mois : </label>
                      <select id="lstMois" name="lstMois">
                            <?php
                                        foreach ($lesMois as $unMois)
                                        {
                                            $mois = $unMois['mois'];
                                            $numAnnee =  $unMois['numAnnee'];
                                            $numMois =  $unMois['numMois'];
                                            if($mois == $moisASelectionner){
                                            ?>
                                            <option selected value="<?php echo $mois ?>"><?php echo  $numMois."/".$numAnnee ?> </option>
                                            <?php 
                                            }
                                            else{ ?>
                                            <option value="<?php echo $mois ?>"><?php echo  $numMois."/".$numAnnee ?> </option>
                                            <?php 
                                            }

                                        }

                                   ?>    
            
                       </select>
                      <br/><br/>
                      </fieldset>
                      <input class="button" type="reset" value="Effacer" />
                      <input class="button" type="submit" value="Valider" />
                  </div>
                </form><br/>
        </article>
    
            