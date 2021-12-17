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
?>

    <h4 class="text-center">Nom du technicien : <b><?= $_SESSION['prenom_technicien'] . " " . $_SESSION['nom_technicien'] ?></b></h4>
    <form id="formulaireInfoTech">
        <div class="container mt-5 d-flex justify-content-center">        
            <dl class="row col-sm-8 border border-dark pt-2 bg-light justify-content-center" style="padding: 10px;">
                <h4 id="titreH4" class="text-center w-100" style="background-color: #079992; height: 40px;">VOS INFORMATIONS</h4>
                <div id="container" class="row vert py-2">

                <div class="col-sm-4">
                    <label for="adresse_technicien" class="col-form-label"><b>Adresse :</b></label>
                </div>                
                <div class="col-sm-8 mb-1">
                    <input type="text" id="adresse_technicien" name="voie_technicien" class="voie form-control" placeholder="Voie..." value="<?= $infoTechnicien_technicien['voie_technicien'] ?>" onFocus="this.value='';">
                    <input type="number" id="adresse_technicien" name="CP_technicien" class="cp form-control" placeholder="Code postal" value="<?= $infoTechnicien_technicien['CP_technicien'] ?>" onFocus="this.value='';">
                    <input type="text" id="adresse_technicien" name="ville_technicien" class="ville form-control" placeholder="Ville" value="<?= $infoTechnicien_technicien['ville_technicien'] ?>" onFocus="this.value='';">                
                </div>

                <div class="col-sm-4 mb-1">
                    <label for="tel_technicien" class="col-form-label"><b>Téléphone mobile :</b></label>
                </div>
                <div class="col-sm-8 mb-1">
                    <input type="number" id="tel_technicien" name="tel_technicien" class="form-control" placeholder="N° de tel mobile" value="<?= $infoTechnicien_technicien['tel_technicien'] ?>" onFocus="this.value='';">
                </div>                

                <div class="col-sm-4 mb-1">
                    <label for="mail_technicien" class="col-form-label"><b> Mail : </b></label>
                </div>
                <div class="col-sm-8 mb-1">
                    <input type="text" id="mail_technicien" name="mail_technicien" class="form-control" placeholder="Adresse E-mail" value="<?= $infoTechnicien_technicien['mail_technicien'] ?>" onFocus="this.value='';">
                </div>                

                <div id="ErreurServeur"></div>
                <div class="d-flex justify-content-center mt-4">
                    <button type="submit" name="submit" class="btn btn-warning"><i class="fas fa-user-check me-2"></i>Enregistrer vos informations</button>
                </div>
            </dl>
        </div>
    </form>


    <div class="d-flex justify-content-center mt-4">
        <a href="informationsTechnicien.php" type="button" class="btn btn-secondary">Annuler</a>
    </div>

<script src="js\modifInfoTech.js"></script>
<?php
include "footer.php";
?>