<br/>
<article>
<h3>Fiche de frais du mois 12-2014 : </h3>
            
            <form action="index.php?uc=suivreFrais&action=miseEnPaiement" method="post">
                <div class="form_settings">
                    <fieldset class="cadre"><br/>
                        Etat : <mark><?php echo $libelleEtat ?></mark> depuis le <mark><?php echo $dateModif ?></mark>, Montant validé : <mark><?php echo $montant ?></mark>.<br/><br/>  
                        <label for="#" accesskey="#">Etat fiche : </label>
                            <select id="#" name="#">
                                <option selected value="">Mise en paiement</option>
                                <option value="">validé</option> 
                            </select><br/><br/>
                    </fieldset>
                    <input class="button" type="submit" value="Valider"/>
                </div>
            </form>
            
            <br/><br/><br/><br/>
            <div class="encadre">
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
                                         $quantite = $unFraisForfait['quantite'];
                                         ?> 
                                         <td><?php echo $quantite ?></td>
                                        <?php
                                        }
                                        ?>
                                     </tr>
                        </table>    
                </fieldset>
                    
                    <br/><br/>
                    
                <fieldset class="cadre">
                        <form action="#" method="post">
                            <div class="form_settings">
                                <table style="width:100%; border-spacing:0;">
                                    <caption>Descriptif des éléments hors forfait - <?php echo $nbJustificatifs ?> justificatifs reçus -</caption>
                                    <tr>
                                        <th class="date">Date</th>
                                        <th class="libelle">Libellé</th>
                                        <th class='montant'>Montant</th>
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
                                    </tr>
                                    <?php
                                    }
                                    ?>
                                </table>
                            </div>
                        </form>
                    </fieldset>
            </div>
        </article>
        
        
        
    </div>