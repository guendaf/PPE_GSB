            <article>
             <table style="width:100%; border-spacing:0;">
                <caption>Descriptif des éléments hors forfait</caption>
                    <tr>
                       <th class="date">Date</th>
                       <th class="libelle">Libellé</th>  
                       <th class="montant">Montant</th>  
                       <th class="action">&nbsp;</th>              
                    </tr>
                    <?php 
                        foreach($lesFraisHorsForfait as $unFraisHorsForfait){
                            $id = $unFraisHorsForfait['id'];
                            $date = $unFraisHorsForfait['date'];
                            $libelle = $unFraisHorsForfait['libelle'];
                            $montant = $unFraisHorsForfait['montant'];
                        ?>
                    <tr>
                        <td><?php echo $date ?></td>
                        <td><?php echo $libelle ?></td>
                        <td><?php echo $montant ?></td>
                        <td><a href="index.php?uc=gererFrais&action=supprimerFrais&idFrais=<?php echo $id ?>" 
                                onclick="return confirm('Voulez-vous vraiment supprimer ce frais?');">Supprimer ce frais</a></td>
                    </tr>
                        <?php
                        }
                        ?>
             </table>
            </article>
            <article>
            </br>
            <fieldset class="cadre">
                <legend>Nouvel élément hors forfait</legend>
                    <form action="index.php?uc=gererFrais&action=validerCreationFrais" method="post">
                        <div class="form_settings">

                                <label for="txtDateHF">Date (jj/mm/aaaa): </label>
                                <input type="text" id="txtDateHF" name="dateFrais" size="10" maxlength="10" value=""  /></br></br>

                                <label for="txtLibelleHF">Libellé</label>
                                <input type="text" id="txtLibelleHF" name="libelle" size="70" maxlength="256" value="" /></br></br>

                                <label for="txtMontantHF">Montant : </label>
                                <input type="text" id="txtMontantHF" name="montant" size="10" maxlength="10" value="" /></br></br>

                                <input id="ajouter" type="submit" value="Ajouter" size="20" />
                                <input id="effacer" type="reset" value="Effacer" size="20" />  
                        </div>
                    </form>
            </fieldset>   
        </article>
    </div>