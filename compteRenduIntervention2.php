<?php
include "header.php";
session_start();  // Démarrage de la session pour avoir accès à '$_SESSION'
    include "database.php";  // connexion à la bdd
    $pdo = Database::connect();
    // On vérifie que le technicien est bien en ligne
    if (key_exists("prenom_technicien", $_SESSION) && key_exists("nom_technicien", $_SESSION)){    
        // On récupère les informations du rdv, du technicien et du client en fonction de l'id du rdv
        $req = $pdo->prepare("SELECT f.*, c.*, d.* FROM `t_factures` AS f JOIN `t_clients` AS c ON fk_client_id = c.id_client JOIN `t_devis` AS d ON fk_devis_id = d.id_devis WHERE f.id_facture = :id_facture"); 
        $req->bindValue(":id_facture", $_GET['id_facture'], PDO::PARAM_INT);
        $req->execute();
        $facture_facture = $req->fetch();
        Database::disconnect();
    } else{
        echo "<script>window.location.href='disconnect.php'</script>";
    }
?>

    <h4 class="text-center mt-5"><b><u>COMPTE-RENDU d'INTERVENTION du technicien</u></b></h4><br>
    <h5 class="text-center">2nde PARTIE</h5>
    <h4 class="text-center">Nom du technicien : <b><?= $_SESSION['prenom_technicien'] . " " . $_SESSION['nom_technicien'] ?></b></h4>
    <h4 class="text-center">Durée d'intervention :</h4>

    <nav class="d-flex">
        <section>
            <article>
                <div class="container mt-5 d-flex justify-content-center">
                    <dl class="row col-sm-10 border border-dark pt-2 bg-light" style="padding: 10px;">
                        <dt class="col-sm-4">Nature du traitement :</dt>
                        <dd class="col-sm-8 jaune1"><?= $facture_facture['nature_traitement_devis'] ?></dd>
                        
                        <dt class="col-sm-4">Adresse du RDV :</dt>
                        <dd class="col-sm-8 mt-1">
                            <p class="px-2 jaune1"><?=$facture_facture['adresse_rue_client'] ?></p>
                            <p class="px-2 jaune1"><?= $facture_facture['adresse_CP_client'] ?></p>
                            <p class="px-2 jaune1"><?= $facture_facture['adresse_ville_client'] ?></p>
                        </dd>
                        
                        <dt class="col-sm-4">Nom :</dt>
                        <dd class="col-sm-8 jaune1"><?= $facture_facture['nom_client'] ?></dd>
                        
                        <dt class="col-sm-4">Prénom :</dt>
                        <dd class="col-sm-8 jaune1"><?= $facture_facture['prenom_client'] ?></dd>
                    </dl>
                </div>
            </article>
            <article>
                <div class="container mt-3 d-flex justify-content-center">        
                    <dl class="row col-sm-10 border border-dark pt-2 bg-light justify-content-center" style="padding: 10px;">
                        <h4 class="text-center w-100" style="background-color: #EA2027; height: 40px;">FACTURE</h4>
                        <div id="container" class="row vert py-2">
                            <dt class="col-sm-4">Numéro Facture :</dt>
                            <dd class="col-sm-8 bleu"><?= $facture_facture['numero_facture'] ?></dd>

                            <dt class="col-sm-4">Nature des locaux :</dt>
                            <dd class="col-sm-8 jaune2"><?= $facture_facture['locaux_devis'] ?></dd>
                            
                            <dt class="col-sm-4">Nombre de pièces :</dt>
                            <dd class="col-sm-8 blanc"><?= $facture_facture['nb_pieces_devis'] ?></dd>
                            
                            <dt class="col-sm-4 mt-1">Surface en m² :</dt>
                            <dd class="col-sm-8 mt-1 blanc"><?= $facture_facture['surface_devis'] ?></dd>

                            <dt class="col-sm-4 mt-1">Hauteur en m :</dt>
                            <dd class="col-sm-8 mt-1 blanc"><?= $facture_facture['hauteur_devis'] ?></dd>

                            <dt class="col-sm-4 mt-1">Volume en m³ :</dt>
                            <dd class="col-sm-8 mt-1 bleu"><?= $facture_facture['volume_devis'] ?></dd>

                            <dt class="col-sm-4">TTC facture :</dt>
                            <dd class="col-sm-8 orange"><?= $facture_facture['facture_ttc'] ?></dd> 
                            
                            <dt class="col-sm-4">Acompte :</dt>
                            <dd class="col-sm-8 orange"><?= $facture_facture['acompte_facture'] ?></dd>
                            
                            <dt class="col-sm-4">Solde à régler :</dt>
                            <dd class="col-sm-8 rouge"><?= $facture_facture['facture_ttc']-$facture_facture['acompte_facture']-$facture_facture['montant_CB_facture']-$facture_facture['montant_cheque_facture'] ?></dd>                
                        </div>
                        <div class="d-flex justify-content-center mt-4">
                            <button type="button" class="btn btn-success"><i class="fas fa-envelope-open-text me-2"></i>Envoi facture mail client</button>
                        </div>
                    </dl>
                </div>
            </article>
        </section>
        <aside>
            <form id="facture" method="POST">
                <div class="container mt-5 d-flex justify-content-center">        
                    <dl class="row col-sm-10 border border-dark pt-2 bg-light justify-content-center" style="padding: 10px;">
                        <h4 class="text-center w-100" style="background-color: #EA2027; height: 40px;">REGLEMENT FACTURE</h4>
                        <div id="container" class="row vert py-2 mt-5">
                            <dt class="col-sm-4">Numéro Facture :</dt>
                            <dd class="col-sm-8 bleu"><?= $facture_facture['numero_facture'] ?></dd>
                            <dt class="my-3"></dt>
                            <dt class="col-sm-4">TTC facture :</dt>
                            <dd class="col-sm-8 orange"><?= $facture_facture['facture_ttc'] ?></dd> 
                            
                            <dt class="col-sm-4">Acompte :</dt>
                            <dd class="col-sm-8 orange"><?= $facture_facture['acompte_facture'] ?></dd>
                            
                            <dt class="col-sm-4">Solde à régler :</dt>
                            <dd class="col-sm-8 rouge"><?= $facture_facture['facture_ttc']-$facture_facture['acompte_facture']-$facture_facture['montant_CB_facture']-$facture_facture['montant_cheque_facture'] ?></dd>
                        </div>
                        <h3 class="text-center mt-4">REGLEMENT par CB</h3>
                        <div id="container" class="row vert py-2 mt-2">
                            <dt class="col-sm-4">Numéro transaction :</dt>
                            <input class="col-sm-8 bleu CB" type="number" name="num_transaction_facture" id="num_transaction_facture" value="<?= $facture_facture['num_transaction_facture'] ?>"> 
                            
                            <dt class="col-sm-4">Montant :</dt>
                            <input class="col-sm-8 orange CB" type="number" name="montant_CB_facture" id="montant_CB_facture" value="<?= $facture_facture['montant_CB_facture'] ?>">         
                        </div>
                        <h3 class="text-center mt-4">REGLEMENT par chèque</h3>
                        <div id="container" class="row vert py-2 mt-2">
                            <dt class="col-sm-4">Numéro du chèque :</dt>
                            <input class="col-sm-8 bleu cheque" type="number" name="num_cheque_facture" id="num_cheque_facture" value="<?= $facture_facture['num_cheque_facture'] ?>"> 
                            
                            <dt class="col-sm-4">Montant :</dt>
                            <input class="col-sm-8 orange cheque" type="number" name="montant_cheque_facture" id="montant_cheque_facture" value="<?= $facture_facture['montant_cheque_facture'] ?>">
                            
                            <dt class="col-sm-4">N° Carte Identité Client :</dt>
                            <input class="col-sm-8 jaune2 cheque" type="number" name="num_ci_facture" id="num_ci_facture" value="<?= $facture_facture['num_ci_facture'] ?>">
                            
                            <dt class="col-sm-4">Date CI Client :</dt>
                            <input class="col-sm-8 jaune2 cheque" type="date" name="date_ci_facture" id="date_ci_facture" value="<?= $facture_facture['date_ci_facture'] ?>">
                            
                            <dt class="col-sm-4">Préfecture :</dt>
                            <input class="col-sm-8 jaune2 cheque" type="text" name="prefecture_ci_facture" id="prefecture_ci_facture" value="<?= $facture_facture['prefecture_ci_facture'] ?>">                     
                        </div>
                    </dl>
                </div>    
                <div class="d-flex justify-content-center ms-3 my-3">
                    <button id="btnEnregistrer" type="submit" name="submit" class="btn btn-secondary btn-lg"><i class="far fa-check-circle me-2"></i>ENREGISTRER</button>
                </div>
            </form>
        </aside>
    </nav>

<script src="js\compteRenduIntervention2.js"></script>

<?php
include "footer.php";
?>