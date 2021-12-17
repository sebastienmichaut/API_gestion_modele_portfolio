<?php
include "header.php";
session_start();  // Démarrage de la session pour avoir accès à '$_SESSION'
    include "database.php";  // connexion à la bdd
    $pdo = Database::connect();
    // On récupère les informations du rdv, du technicien et du client en fonction de l'id du rdv
    $req = $pdo->prepare("SELECT * FROM `t_techniciens` WHERE id_technicien = :id_technicien "); 
    $req->bindValue(":id_technicien", $_SESSION['id_technicien'],PDO::PARAM_INT);
    $req->execute();
    $infoTechnicien_technicien = $req->fetch();

    Database::disconnect();
?>

    <h4 class="text-center">Nom du technicien : <b><?= $_SESSION['prenom_technicien'] . " " . $_SESSION['nom_technicien'] ?></b></h4>

    <div class="container mt-5 d-flex justify-content-center">        
        <dl class="row col-sm-8 border border-dark pt-2 bg-light justify-content-center" style="padding: 10px;">
            <h4 id="titreH4" class="text-center w-100" style="background-color: #079992; height: 40px;">VOS INFORMATIONS</h4>
            <div id="container" class="row vert py-2">
            <dt class="col-sm-4">Genre :</dt>
            <dd class="col-sm-8 bleu"><?= $infoTechnicien_technicien['genre_technicien'] ?></dd>

            <dt class="col-sm-4">Prénom :</dt>
            <dd class="col-sm-8 bleu"><?= $infoTechnicien_technicien['prenom_technicien'] ?></dd>

            <dt class="col-sm-4">Nom :</dt>
            <dd class="col-sm-8 jaune1"><?= $infoTechnicien_technicien['nom_technicien'] ?></dd>
        
            <dt class="col-sm-4">Votre adresse :</dt>
            <dd class="col-sm-8 mt-1">
            <p class="px-2 jaune1"><?=$infoTechnicien_technicien['voie_technicien'] ?></p>
            <p class="px-2 jaune1"><?= $infoTechnicien_technicien['CP_technicien'] ?></p>
            <p class="px-2 jaune1"><?= $infoTechnicien_technicien['ville_technicien'] ?></p>
            </dd>
        
            <dt class="col-sm-4">Téléphone mobile :</dt>
            <dd class="col-sm-8 jaune1"><?= $infoTechnicien_technicien['tel_technicien'] ?></dd>
            
            <dt class="col-sm-4">Mail :</dt>
            <dd class="col-sm-8 jaune1"><?= $infoTechnicien_technicien['mail_technicien'] ?></dd>

            <dt class="col-sm-4">Numéro de Sécurité sociale :</dt>
            <dd class="col-sm-8 bleu"><?= $infoTechnicien_technicien['num_secu_technicien'] ?></dd>            

            <dt class="col-sm-4">Carte d'identité :</dt>
            <dd class="col-sm-8 mt-1">
            <p class="px-2 jaune2"><?= $infoTechnicien_technicien['num_ci_technicien'] ?></p>
            <p class="px-2 jaune2"><?= $infoTechnicien_technicien['date_ci_technicien'] ?></p>
            <p class="px-2 jaune2"><?= $infoTechnicien_technicien['prefecture_ci_technicien'] ?></p>
            </dd>

            <dt class="col-sm-4">Département couvert :</dt>
            <dd class="col-sm-8 blanc"><?= $infoTechnicien_technicien['departement_technicien'] ?></dd>
            
            <dt class="col-sm-4 mt-1">Nombre d'interventions :</dt>
            <dd class="col-sm-8 mt-1 blanc"><?= $infoTechnicien_technicien['nb_interventions_technicien'] ?></dd>

            <dt class="col-sm-4 mt-1">Nombre de devis :</dt>
            <dd class="col-sm-8 mt-1 blanc"><?= $infoTechnicien_technicien['nombre_devis_technicien'] ?></dd>

            <dt class="col-sm-4 mt-1">Nombre de factures :</dt>
            <dd class="col-sm-8 mt-1 bleu"><?= $infoTechnicien_technicien['nombre_factures_technicien'] ?></dd>

            </div>
            <div class="d-flex justify-content-center mt-4">
                <a href="modifInfoTech.php" type="button" class="btn btn-info"><i class="fas fa-book me-2"></i>Modifier vos informations</a>
            </div>
        </dl>
    </div>

<?php
include "footer.php";
?>