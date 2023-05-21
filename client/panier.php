<?php

    if(!isset($_POST['payer_com']) OR !isset($_POST['submit_com'])){
        //header("Location: index.php");
    }

    
    if(isset($_POST['payer_com'])){
        include("../connexion.inc.php");
        //INSERT INTO commande (date, etat, idres, idcli)VALUES (1970-01-01, 'en attente', 3, 2);

        date_default_timezone_set('Europe/Paris');
        $date = date('Y-m-d H:i:s');
        $etat = "en attente";
        $idres = $_POST['idres'];
        //$id -> idclient

        // Ajout d'une nouvelle commande
        $add_commande = $cnx->query("INSERT INTO commande 
                                    (date_a, etat, idres, idcli) VALUES 
                                    ('$date','$etat', '$idres', '$id') RETURNING numcom;");

        $get_numcom = $add_commande->fetch();
        $numcom = $get_numcom['numcom'];

        $panier = $_SESSION['panier'];

        // Ajout des plats dans la table contenir
        for($i=0; $i < count($panier); $i++) {
            //PANIER(id plat, nomplat, quantité, prix_unit, prix_final)
            $idplat=$panier[$i][0];
            $quantite =$panier[$i][2];
            $cnx->exec("INSERT INTO contenir (numcommande, idplat, quantite)
                        VALUES ('$numcom', '$idplat', '$quantite');");
        }
        $_SESSION['panier']=NULL;
        header("Location: index.php?page=confirmation");

    }

?>

<div class="panier-block">
    <div class="panier-title">
        Votre panier
    </div>

    <!--Listes des plats à commander-->
    <form action="#" method="POST">
        <div class="list-panier-block">
            <?php

            if(isset($_POST['submit_com'])){

                $lst_quantite = $_POST['quantite'];
                $lst_selected = $_POST['selected_id'];
                $lst_nomplat = $_POST['selected_nom'];
                $lst_prix = $_POST['prixU'];

                $id_res = $_POST['idres'];
                $prix_livraison = $_POST['prixlivraison'];

                $panier=array();
                for($i=0; $i < count($lst_quantite); $i++){
                    
                    if($lst_quantite[$i] > 0){
                        $prixf=$lst_prix[$i]*$lst_quantite[$i];

                        //id plat, nomplat, quantité, prix unit, prix final
                        $item = array($lst_selected[$i],$lst_nomplat[$i], $lst_quantite[$i], $lst_prix[$i], $prixf);

                        array_push($panier, $item);
                    }
                }
                if(count($panier) == 0){
                    header("Location: index.php?page=restaurant&&idres=".$id_res."");
                }
                //print_r($panier);
                $_SESSION['panier'] = $panier;

                //echo "<input type='hidden' name='panier' value='".$panier."'/>";
                echo "<input type='hidden' name='idres' value='".$id_res."'/>";
                
                $total = 0; 
                for($i=0; $i<count($panier); $i++){
                    
                    $total+=$panier[$i][4];
                    echo "
                    <div class='panier-item'>
                        <div class='panier-item-name'>
                            ".$panier[$i][1]."
                        </div>
                        <div class='panier_item-quantite'>
                            Quantité(s) : ".$panier[$i][2]."
                        </div>
                        <div class='panier-item-price'>
                            ".$panier[$i][4]." €
                        </div>
                    </div>
                    ";
                }

                $total+=$prix_livraison;
                echo "
                <div class='panier-item'>
                        <div class='panier-item-name'>
                            
                        </div>
                        <div class='panier_item-quantite'>
                           Prix Livraison
                        </div>
                        <div class='panier-item-price'>
                            ".$prix_livraison." €
                        </div>
                </div>";

                //Application de points de fidélité
                if($pointsfidelite >= 5){
                	$reduction = 5;
                	$total_reduc = $total-5;
                }else{
                	$reduction = 0;
                	$total_reduc = $total;
                }

                echo "
                    <div class='panier-item total-block'>
                        <div class='total-prix'>
                           $total €<br/>
                           -$reduction €<br/>
                           <b>$total_reduc €</b>

                        </div>
                        <div class='total'>
                            Total :<br/>
                            Réduction :<br/>
                            Reste à payer :

                        </div>
                    </div>
                ";
            }

            ?>
        </div>
        <div class="pay-button-block">
            <input type="submit" name="payer_com" value="PAYER" class="pay-button" />
        </div>
    </form>
</div>