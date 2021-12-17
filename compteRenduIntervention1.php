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

    <h4 class="text-center mt-5"><b><u>COMPTE-RENDU d'INTERVENTION du technicien</u></b></h4><br>
    <h5 class="text-center">1ere PARTIE</h5>
    <h4 class="text-center">Nom du technicien : <b><?= $_SESSION['prenom_technicien'] . " " . $_SESSION['nom_technicien'] ?></b></h4>


    <div class="container mt-5 d-flex justify-content-center">
        <dl class="row col-sm-6 border border-dark pt-2 bg-light" style="padding: 10px;">
          <dt class="col-sm-4">Nature du traitement :</dt>
          <dd class="col-sm-8 jaune1"><?= $rdv_technicien['nature_traitement_devis'] ?></dd>
        
          <dt class="col-sm-4">Adresse du RDV :</dt>
          <dd class="col-sm-8 mt-1">
            <p class="px-2 jaune1"><?=$rdv_technicien['adresse_rue_rdv_gestion_rdv'] ?></p>
            <p class="px-2 jaune1"><?= $rdv_technicien['adresse_CP_rdv_gestion_rdv'] ?></p>
            <p class="px-2 jaune1"><?= $rdv_technicien['lieu_rdv_gestion_rdv'] ?></p>
          </dd>
        
          <dt class="col-sm-4">Nom :</dt>
          <dd class="col-sm-8 jaune1"><?= $rdv_technicien['nom_client'] ?></dd>
        
          <dt class="col-sm-4">Prénom :</dt>
          <dd class="col-sm-8 jaune1"><?= $rdv_technicien['prenom_client'] ?></dd>
        </dl>
    </div>

    <div class="container mt-5 d-flex justify-content-center">        
        <dl class="row col-sm-6 border border-dark pt-2 bg-light justify-content-center" style="padding: 10px;">
            <h4 id="titreH4" class="text-center w-100" style="background-color: #079992; height: 40px;">TRAITEMENT réalisé</h4>
            <h5 id="titreH5" class="text-center mb-3 fw-bold">Devis Initial</h5>
            <div id="container" class="row vert py-2">
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
            </div>
            <div id="boutonDynamique" class="d-flex justify-content-between mt-4">
                <button type="button" class="btn btn-success" id="validerVolume"><i class="far fa-check-circle me-2"></i>Valider Volume</button>
                <a href="nouveauDevis.php?id_rdv=<?= $_GET['id_rdv'] ?>"><button type="button" class="btn btn-warning"><i class="far fa-edit me-2"></i>Modifier le devis</button></a>
            </div>
        </dl>
    </div>


    <div class="d-flex justify-content-center mt-4">
        <div class="mb-3 row col-10 col-sm-8 col-md-5">
            <label for="commentaires" class="form-label vert col-sm-6 col-lg-3" id="commentaires"><b>Commentaires :</b></label>
            <textarea class="form-control" id="commentaires" rows="3" disabled><?= $rdv_technicien['commentaires_devis'] ?></textarea>
            <div id="reglement" class="ms-3 my-3">
                <button id="boutonReglement" type="button" class="btn btn-secondary"><i class="fas fa-arrow-circle-right me-2"></i>suite : REGLEMENT</button>
            </div>
        </div>
    </div>

<script src="js\compteRenduIntervention1.js"></script>

<?php
include "footer.php";
?>