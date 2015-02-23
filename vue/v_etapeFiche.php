            <article>
                 <h3>Fiche de frais du mois 12-2014 : </h3>
                    <form action="index.php?uc=validerFrais&action=validerFiche" method="post">
                        <div class="form_settings">
                            <fieldset class="cadre"><br/>
                                Etat : <mark><?php echo $libEtat ?></mark> depuis le <mark><?php echo $dateModif ?></mark>, montant validé : <mark><?php echo $montant ?></mark> E.
                                 <br/><br/>
                            </fieldset>
                                <input class="button" type="submit" value="Valider" />
                        </div>
                    </form>
                    
                    <br/><br/><br/><br/>
                    
                    <form action="index.php?uc=validerFrais&action=actualiserFicheFrais" method="post">
                        <div class="form_settings">
                            <fieldset class="cadre">
                                <table style="width:100%; border-spacing:0;">
                                   <caption>Eléments forfaitisés </caption>
                                     <tr>
                                         <?php
                                         foreach ($LesFraisForfait as $unFraisForfait)
                                         {
                                         $libelle = $unFraisForfait['libelle'];
                                             
                                         ?>
                                         <th><?php echo $libelle ?></th>
                                        <?php
                                         }
                                        ?>
                                     </tr>
                                     <tr>
                                         <?php 
                                         foreach($LesFraisForfait as $unFraisForfait)
                                         {
                                         $idFrais = $unFraisForfait['idfrais'];
                                         $quantite = $unFraisForfait['quantite'];
                                         ?> 
                                         <td><input type="text" size="17" maxlength="45" name="lesFrais[<?php echo $idFrais ?>]" value="<?php echo $quantite ?>"/></td>
                                        <?php
                                        }
                                        ?>
                                     </tr>
                                </table>
                            </fieldset>
                            <input class="button" type="submit" value="Actualiser" />
                        </div>
                    </form>
                    
                    
                    <br/><br/><br/><br/>
                    
                    
                    <form action="#" method="post">
                        <div class="form_settings">
                            <fieldset class="cadre">
                                <table style="width:100%; border-spacing:0;">
                                    <caption>Descriptif des éléments hors forfait - 3 justificatifs reçus -</caption>
                                    <tr>
                                        <th class="date">Date</th>
                                        <th class="libelle">Libellé</th>
                                        <th class='montant'>Montant</th>
                                        <th class='montant'>Etat</th>
                                    </tr>
                                    <?php
                                    foreach($LesFraisHorsForfait as $unFraisHorsForfait)
                                    {
                                        $id = $unFraisHorsForfait['id'];
                                        $date=$unFraisHorsForfait['date'];
                                        $libelle=$unFraisHorsForfait['libelle'];
                                        $montant=$unFraisHorsForfait['montant'];
                                    ?>
                                    <tr>
                                        <td><?php echo $date ?></td>
                                        <td class="refus"><style>.refus{color:red}</style><?php echo $libelle ?></td>
                                        <td><?php echo $montant ?></td>
                                        <td><a href="index.php?uc=validerFrais&action=supprimerFicheFrais&id=<?php echo $id ?>&libelle=<?php echo $libelle ?>
                                               &montantHF=<?php echo $montant ?>&dateHF=<?php echo $date ?>"
                                               onclick="return confirm('Voulez-vous vraiment supprimer ce frais?');">Supprimer</a></td>
                                    </tr>
                                    <?php
                                    }
                                    ?>
                                </table>
                            </fieldset>
                        </div>
                    </form>                
            </article>
        </div>