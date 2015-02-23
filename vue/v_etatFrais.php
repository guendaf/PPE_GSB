        <article>
            <h3>Fiche de frais du mois <?php echo $numMois."/".$numAnnee?> : </h3>
            <div class="encadre">
                <fieldset class="cadre"><br/>
                    Etat : <mark><?php echo $libEtat ?></mark> depuis le <mark><?php echo $dateModif ?></mark>, Montant validé : <mark><?php echo $montantValide ?></mark>.
                    <br/><br/>
                </fieldset><br/><br/>
                <fieldset class="cadre"><br/>
                    <table style="width:100%; border-spacing:0;">
                       <caption>Eléments forfaitisés </caption>
                         <tr>
                             <?php
                                foreach ( $lesFraisForfait as $unFraisForfait ) 
                                {
                                        $libelle = $unFraisForfait['libelle'];
                                ?>	
                                    <th> <?php echo $libelle?></th>
                                <?php
                                }
                                ?>
                        </tr>
                        <tr>
                            <?php
                            foreach (  $lesFraisForfait as $unFraisForfait  ) 
                            {
				$quantite = $unFraisForfait['quantite'];
                            ?>
                            <td><?php echo $quantite?> </td>
                           <?php
                            }
                            ?>
                        </tr>
                    </table><br/>
                </fieldset>
                    <br/><br/>
                <fieldset class="cadre"><br/>
                    <table style="width:100%; border-spacing:0;">
                        <caption>Descriptif des éléments hors forfait - 3 justificatifs reçus -</caption>
                         <tr>
                            <th>Date</th>
                            <th>Libellé</th>
                            <th>Montant</th>
                         </tr>
                         <?php
                             foreach($lesFraisHorsForfait as $unFraisHorsForfait){
                                 $date = $unFraisHorsForfait['date'];
                                 $libelle = $unFraisHorsForfait['libelle'];
                                 $montant = $unFraisHorsForfait['montant'];
                         ?>
                         <tr>
                            <td><?php echo $date ?></td>
                            <td><?php echo $libelle ?></td>
                            <td><?php echo $montant ?></td>
                         </tr>
                         <?php
                          }
                         ?>
                    </table>
                </fieldset>
            </div>
        </article>
    </div>