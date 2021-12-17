<?php
include "header.php";
session_start();  // Démarrage de la session pour avoir accès à '$_SESSION'
    include "database.php";  // connexion à la bdd
    $pdo = Database::connect();
    // On récupère les informations du rdv, du technicien et du client en fonction de l'id du rdv
    $req = $pdo->prepare("SELECT g.*, t.*, c.*, d.* FROM `t_gestion_rdv` AS g JOIN `t_techniciens` AS t ON fk_technicien_id = t.id_technicien JOIN `t_clients` AS c ON fk_client_id = c.id_client JOIN `t_devis`AS d ON fk_gestion_rdv_id = g.id_rdv WHERE g.id_rdv = :id_rdv"); 
    $req->bindValue(":id_rdv", $_GET['id_rdv'],PDO::PARAM_INT);
    $req->execute();
    $rdv_technicien = $req->fetch();

    // On récupère l'id de la facture
    $req = $pdo->prepare("SELECT id_facture FROM `t_factures` WHERE fk_gestion_rdv_id=:id_rdv");
    $req->bindValue(":id_rdv", $_GET['id_rdv'], PDO::PARAM_INT);
    $req->execute();
    $id_facture = $req->fetch();
    Database::disconnect();
?>

    <h4 class="text-center mt-5"><b><u>DETAILS DU RDV</u></b></h4><br>

    <h4 class="text-center">Nom du technicien : <b><?= $_SESSION['prenom_technicien'] . " " . $_SESSION['nom_technicien'] ?></b></h4>

    <div class="container mt-5 d-flex justify-content-center">        
        <dl class="row col-sm-6 border border-dark pt-2 bg-light justify-content-center" style="padding: 10px;">
            <h4 id="titreH4" class="text-center w-100" style="background-color: #079992; height: 40px;">DETAILS DU RDV</h4>
            <div id="container" class="row vert py-2">
            <dt class="col-sm-4">Heure début RDV:</dt>
            <dd class="col-sm-8 bleu"><?= $rdv_technicien['heure_debut_gestion_rdv'] ?></dd>

            <dt class="col-sm-4">Heure fin RDV:</dt>
            <dd class="col-sm-8 bleu"><?= $rdv_technicien['heure_fin_gestion_rdv'] ?></dd>

            <dt class="col-sm-4">Nature du traitement :</dt>
            <dd class="col-sm-8 jaune1"><?= $rdv_technicien['nature_traitement_devis'] ?></dd>
        
            <dt class="col-sm-4">Adresse du RDV :</dt>
            <dd class="col-sm-8 mt-1">
            <p class="px-2 jaune1"><?=$rdv_technicien['adresse_rue_client'] ?></p>
            <p class="px-2 jaune1"><?= $rdv_technicien['adresse_CP_client'] ?></p>
            <p class="px-2 jaune1"><?= $rdv_technicien['adresse_ville_client'] ?></p>
            </dd>
        
            <dt class="col-sm-4">Nom :</dt>
            <dd class="col-sm-8 jaune1"><?= $rdv_technicien['nom_client'] ?></dd>
            
            <dt class="col-sm-4">Prénom :</dt>
            <dd class="col-sm-8 jaune1"><?= $rdv_technicien['prenom_client'] ?></dd>

            <dt class="col-sm-4">Tel mobile :</dt>
            <dd class="col-sm-8 jaune1"><?= $rdv_technicien['tel_mobile_client'] ?></dd>

            <dt class="col-sm-4">Tel fixe :</dt>
            <dd class="col-sm-8 jaune1"><?= $rdv_technicien['tel_fixe_client'] ?></dd>

            <dt class="col-sm-4">Numéro Devis :</dt>
            <dd class="col-sm-8 bleu"><?= $rdv_technicien['numero_devis'] ?></dd>            

            <dt class="col-sm-4">Nature des locaux :</dt>
            <dd class="col-sm-8 jaune2"><?= $rdv_technicien['locaux_devis'] ?></dd>
            
            <dt class="col-sm-4">Nombre de pièces :</dt>
            <dd class="col-sm-8 blanc"><?= $rdv_technicien['nb_pieces_devis'] ?></dd>
            
            <dt class="col-sm-4 mt-1">Surface en m² :</dt>
            <dd class="col-sm-8 mt-1 blanc"><?= $rdv_technicien['surface_devis'] ?></dd>

            <dt class="col-sm-4 mt-1">Hauteur en m :</dt>
            <dd class="col-sm-8 mt-1 blanc"><?= $rdv_technicien['hauteur_devis'] ?></dd>

            <dt class="col-sm-4 mt-1">Volume en m³ :</dt>
            <dd class="col-sm-8 mt-1 bleu"><?= $rdv_technicien['volume_devis'] ?></dd>

            <dt class="col-sm-4 mt-1">TTC devis :</dt>
            <dd class="col-sm-8 mt-1 orange"><?= $rdv_technicien['ttc_devis'] ?></dd>

            <dt class="col-sm-4 mt-1">Acompte :</dt>
            <dd class="col-sm-8 mt-1 orange"><?= $rdv_technicien['acompte_devis'] ?></dd>

            </div>
            <div class="d-flex justify-content-between mt-4">
                <a href="planningRdvHebdo.php" type="button" class="btn btn-info"><i class="far fa-calendar-alt me-2"></i>Revenir au planning</a>
                <a href="compteRenduIntervention1.php?id_rdv=<?= $rdv_technicien['id_rdv'] ?>" type="button" class="btn btn-info"><i class="fas fa-book-reader me-2"></i>Compte-Rendu</a>
            </div>
        </dl>
    </div>


    <div class="d-flex justify-content-center mt-4">
        <div class="mb-3 row col-10 col-sm-8 col-md-5">
            <label for="commentaires" class="form-label vert col-sm-6 col-lg-3" id="commentaires"><b>Commentaires :</b></label>
            <textarea class="form-control" id="commentaires" rows="3" disabled><?= $rdv_technicien['commentaires_devis'] ?></textarea>
        </div>
    </div>

<?php
include "footer.php";
?>