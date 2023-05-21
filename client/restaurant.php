<div class="restaurant-block">
    <div class="restaurant-title">
        <?php
            $res = $cnx->query("SELECT nom,adresse,prixlivraison FROM restaurant WHERE idres=".$_GET['idres'].";");
            $get_info=$res->fetch();

            $res2 = $cnx->query("SELECT avg(note) AS avgnote FROM restaurant,commenter WHERE
            restaurant.idres=commenter.idres AND restaurant.idres=".$_GET['idres']." GROUP BY nom,adresse;");
            $get_info2=$res2->fetch();

            echo "<b>".$get_info['nom']."</b>  | Note globale : <b>".floatval($get_info2['avgnote'])."/5</b>| Adresse : ".$get_info['adresse']." | Prix livraison :".$get_info['prixlivraison']."€";
        ?>
    </div>
    <form method="POST" action="?page=panier">
        <div class="menu-list-block">
                <?php
                    if(isset($_GET['idres'])){
                        $resultat = $cnx->query("SELECT * FROM restaurant NATURAL JOIN proposer NATURAL JOIN plat WHERE idres=".$_GET['idres'].";");

                        foreach($resultat AS $data){
                            echo "
                                <div class='menu-item-block'>
                                    <div class='menu-image-block'>
                                        <img src='menu/".$data['imagemenu']."' width='100%' height='100%' />
                                    </div>
                                    <div class='menu-description-block'>
                                        <b>".$data['nomplat']."</b><br/>
                                        <span style='font-size:14px;'>".$data['description']."<br/>
                                        Prix Unit. : <b>".$data['prix']." €</span></b>
                                    </div>
                                    <div class='menu-quantite-block'>
                                        Quantite<br/>
                                        <input type='number' name='quantite[]' value='0' min='0' style='width:50px;'/>
                                    </div>
                                    <div class='menu-checkbox-block'>
                                        <input type='hidden' name='selected_id[]' value='".$data['idplat']."' />
                                        <input type='hidden' name='selected_nom[]' value='".$data['nomplat']."' />
                                        <input type='hidden' name='prixU[]' value='".$data['prix']."'/>

                                        <input type='hidden' name='idres' value='".$data['idres']."' />
                                        <input type='hidden' name='prixlivraison' value='".$data['prixlivraison']."' />

                                    </div>
                                </div>";
                        }
                    }else{
                        header("Location: index.php");  
                    }
                    
                ?>
        </div>
        <div class="menu-button-block">
            <div class="menu-button-left">
                <a href="index.php"><div class="menu-annuler">
                    RETOURNER
                </div></a>
            </div>
            <div class="menu-button-right">
                <input type="submit" name="submit_com" value="COMMANDER" class="menu-commander"/>
            </div>
        </div>
    </form>

    <table class="comment_block">
        <tbody>
            <tr>
                <td>
                    <b>Commentaires des clients</b>
                </td>
            </tr>
            <?php
                if(isset($_GET['idres'])){
                    $res = $cnx->query("SELECT commentaire FROM commenter WHERE idres=".$_GET['idres'].";");

                    $count=0;
                    foreach($res AS $ligne){
                        $count++;
                        echo "
                            <tr>
                                <td>
                                    commentaire [$count] :  ".$ligne['commentaire']."
                                </td>
                            </tr>
                        ";
                    }

                }
            ?>
        </tbody>
    </table>
</div>