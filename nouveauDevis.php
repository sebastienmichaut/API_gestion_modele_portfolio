<?php
include "header.php";
session_start();  // Démarrage de la session pour avoir accès à '$_SESSION'
include "database.php";  // connexion à la bdd
include "script_calcul_prix.php"; // pour utiliser les fonctions de calcul du prix
    $pdo = Database::connect();
    // On récupère les informations du rdv, du technicien et du client en fonction de l'id du rdv
    $req = $pdo->prepare("SELECT g.*, t.*, c.*, d.* FROM `t_gestion_rdv` AS g JOIN `t_techniciens` AS t ON fk_technicien_id = t.id_technicien JOIN `t_clients` AS c ON fk_client_id = c.id_client JOIN `t_devis`AS d ON fk_gestion_rdv_id = g.id_rdv WHERE g.id_rdv = :id_rdv"); 
    $req->bindValue(":id_rdv", $_GET['id_rdv'], PDO::PARAM_INT);
    $req->execute();
    $rdv_technicien = $req->fetch();
    Database::disconnect();
    // On vérifie que le technicien est bien en ligne
    if (key_exists("prenom_technicien", $_SESSION) && key_exists("nom_technicien", $_SESSION)){
        // Si le formulaire HTML à été soumis
        if ($_POST) {   
            $idClient_client = $rdv_technicien["id_client"];
            $idDevis_devis = $rdv_technicien["id_devis"];
            $nomClient_client = htmlspecialchars($_POST["nom_client"]);
            $prenomClient_client = htmlspecialchars($_POST["prenom_client"]);
            $adresseRueRDV_gestion_rdv = htmlspecialchars($_POST["adresse_rue_rdv_gestion_rdv"]);
            $adresseCpRDV_gestion_rdv = htmlspecialchars($_POST["adresse_CP_rdv_gestion_rdv"]);
            $adresseVilleRDV_gestion_rdv = htmlspecialchars($_POST["lieu_rdv_gestion_rdv"]);
            $locauxDevis_devis = htmlspecialchars($_POST["locaux_devis"]);
            $nbPiecesDevis_devis = htmlspecialchars($_POST["nb_pieces_devis"]);
            $surfaceDevis_devis = htmlspecialchars($_POST["surface_devis"]);
            $hauteurDevis_devis = htmlspecialchars($_POST["hauteur_devis"]);
            $volumeDevis_devis = htmlspecialchars($_POST["volume_devis2"]);
            $numeroDevis_devis = htmlspecialchars($_POST["numero_devis"]);
             // Calcul du prix dans script_calcul_prix.php
            if (($rdv_technicien["categorie_client"] == "Particulier") && ($rdv_technicien['nature_traitement_devis'] == ("Bactéries" || "Microbes" || "Virus"))){
                $prixDevis_devis = particulier_formule1_calcul_prix($volumeDevis_devis);
            } else if (($rdv_technicien["categorie_client"] == "Particulier") && ($rdv_technicien['nature_traitement_devis'] == ("Punaises" || "Puces de lit" || "Acariens"))){
                $prixDevis_devis = particulier_formule2_calcul_prix($volumeDevis_devis);
            } else if (($rdv_technicien["categorie_client"] == "Entreprise") && ($rdv_technicien['nature_traitement_devis'] == ("Bactéries" || "Microbes" || "Virus"))){
                $prixDevis_devis = entreprise_formule1_calcul_prix($volumeDevis_devis);
            } else if (($rdv_technicien["categorie_client"] == "Entreprise") && ($rdv_technicien['nature_traitement_devis'] == ("Punaises" || "Puces de lit" || "Acariens"))){
                $prixDevis_devis = entreprise_formule2_calcul_prix($volumeDevis_devis);
            }

            $pdo = Database::connect();
            $req = $pdo->prepare("UPDATE `t_devis` SET 
                numero_devis = :numeroDevis_devis,
                locaux_devis = :locauxDevis_devis,
                nb_pieces_devis = :nbPiecesDevis_devis,
                surface_devis = :surfaceDevis_devis,
                hauteur_devis = :hauteurDevis_devis,
                volume_devis = :volumeDevis_devis,
                ttc_devis = :prixDevis_devis WHERE id_devis = :idDevis_devis");
            $req->bindValue(":numeroDevis_devis", $numeroDevis_devis, PDO::PARAM_STR);            
            $req->bindValue(":locauxDevis_devis", $locauxDevis_devis, PDO::PARAM_STR);
            $req->bindValue(":nbPiecesDevis_devis", $nbPiecesDevis_devis, PDO::PARAM_STR);
            $req->bindValue(":surfaceDevis_devis", $surfaceDevis_devis, PDO::PARAM_STR);
            $req->bindValue(":hauteurDevis_devis", $hauteurDevis_devis, PDO::PARAM_STR);
            $req->bindValue(":volumeDevis_devis", $volumeDevis_devis, PDO::PARAM_STR);
            $req->bindValue(":prixDevis_devis", $prixDevis_devis, PDO::PARAM_INT);
            $req->bindValue(":idDevis_devis", $idDevis_devis, PDO::PARAM_INT);
            $req->execute();
    
            $req = $pdo->prepare("UPDATE `t_clients` SET
                nom_client = :nomClient_client,
                prenom_client = :prenomClient_client
                WHERE id_client = :idClient_client");
            $req->bindValue(":nomClient_client", $nomClient_client, PDO::PARAM_STR);
            $req->bindValue(":prenomClient_client", $prenomClient_client, PDO::PARAM_STR);
            $req->bindValue(":idClient_client", $idClient_client, PDO::PARAM_INT);
            $req->execute();

            $req = $pdo->prepare("UPDATE `t_gestion_rdv` SET
                adresse_rue_rdv_gestion_rdv = :adresseRueRDV_gestion_rdv,
                adresse_CP_rdv_gestion_rdv = :adresseCpRDV_gestion_rdv,
                lieu_rdv_gestion_rdv = :adresseVilleRDV_gestion_rdv
                WHERE id_rdv = :id_rdv");
            $req->bindValue(":adresseRueRDV_gestion_rdv", $adresseRueRDV_gestion_rdv, PDO::PARAM_STR);
            $req->bindValue(":adresseCpRDV_gestion_rdv", $adresseCpRDV_gestion_rdv, PDO::PARAM_STR);
            $req->bindValue(":adresseVilleRDV_gestion_rdv", $adresseVilleRDV_gestion_rdv, PDO::PARAM_STR);
            $req->bindValue(":id_rdv", $_GET['id_rdv'], PDO::PARAM_INT);
            $req->execute();

            echo "<script>window.location.href='compteRenduIntervention1.php?id_rdv={$rdv_technicien['id_rdv']}'</script>";
            Database::disconnect();        
        }
    } else {
        echo "<script>window.location.href='disconnect.php'</script>";
    }
    
?>

    <h4 class="text-center mt-5"><b><u>COMPTE-RENDU d'INTERVENTION du technicien</u></b></h4><br>
    <h5 class="d-flex justify-content-center">1ere PARTIE</h5>

    <div class="container mt-5 d-flex justify-content-center">
        <div class="row col-sm-6 mb-5">
            <h4>Nom du technicien : <b><?= $_SESSION['prenom_technicien'] . " " . $_SESSION['nom_technicien'] ?></b></h4>
        </div>
    </div>
    <form method="post">
        <div class="container mt-5 d-flex justify-content-center">
            <div class="row col-sm-6 border border-dark pt-2 bg-light" style="padding: 10px;">           
                <div class="col-sm-4">
                    <label for="nature_traitement_devis" class="col-form-label">Nature du traitement :</label>
                </div>
                <div class="col-sm-8">
                    <input type="text" id="nature_traitement_devis" name="nature_traitement_devis" class="form-control" value="<?= $rdv_technicien['nature_traitement_devis'] ?>" onFocus="this.value='';">
                </div>
                <div class="col-sm-4">
                    <label for="adresse" class="col-form-label">Adresse du RDV :</label>
                </div>
                <div class="col-sm-8">
                    <input type="text" id="adresse" name="adresse_rue_rdv_gestion_rdv" class="form-control" value="<?=$rdv_technicien['adresse_rue_rdv_gestion_rdv'] ?>" onFocus="this.value='';">   
                    <input type="text" id="adresse" name="adresse_CP_rdv_gestion_rdv" class="form-control" value="<?= $rdv_technicien['adresse_CP_rdv_gestion_rdv'] ?>" onFocus="this.value='';"> 
                    <input type="text" id="adresse" name="lieu_rdv_gestion_rdv" class="form-control" value="<?= $rdv_technicien['lieu_rdv_gestion_rdv'] ?>" onFocus="this.value='';">
                </div>
                <div class="col-sm-4">
                    <label for="nom_client" class="col-form-label">Nom :</label>
                </div>
                <div class="col-sm-8">
                    <input type="text" id="nom_client" name="nom_client" class="form-control" value="<?= $rdv_technicien['nom_client'] ?>" onFocus="this.value='';">
                </div>
                <div class="col-sm-4">
                    <label for="prenom_client" class="col-form-label">Prénom :</label>
                </div>
                <div class="col-sm-8">
                    <input type="text" id="prenom_client" name="prenom_client" class="form-control" value="<?= $rdv_technicien['prenom_client'] ?>" onFocus="this.value='';">
                </div>           
            </div>
        </div>
    
        <div class="container my-5 d-flex justify-content-center">        
            <div class="row col-sm-6 border border-dark pt-2 bg-light justify-content-center" style="padding: 10px;">
                <h4 class="text-center w-100" style="background-color: #079992; height: 40px;">TRAITEMENT réalisé</h4>
                <h5 class="text-center mb-3"><strong>Nouveau devis</strong></h5>
                <div class="row vert py-2">
                    <div class="col-sm-4">
                        <label for="numero_devis" class="col-form-label">Numéro du devis :</label>
                    </div>
                    <div class="col-sm-8">
                        <input type="text" id="numero_devis" name="numero_devis" class="form-control" value="<?= $rdv_technicien['numero_devis'] ?>">
                    </div>                     
                    <div class="col-sm-4">
                        <label for="locaux_devis" class="col-form-label">Nature des locaux :</label>
                    </div>
                    <div class="col-sm-8">
                        <input type="text" id="locaux_devis" name="locaux_devis" class="form-control" value="<?= $rdv_technicien['locaux_devis'] ?>" onFocus="this.value='';">
                    </div>
                    <div class="col-sm-4">
                        <label for="nb_pieces_devis" class="col-form-label">Nombre de pièces :</label>
                    </div>
                    <div class="col-sm-8">
                        <input type="number" id="nb_pieces_devis" name="nb_pieces_devis" class="form-control" value="<?= $rdv_technicien['nb_pieces_devis'] ?>" onFocus="this.value='';">
                    </div>
                    <div class="col-sm-4">
                        <label for="surface_devis" class="col-form-label">Surface en m² :</label>
                    </div>
                    <div class="col-sm-8">
                        <input type="number" id="surface_devis" name="surface_devis" class="form-control" value="<?= $rdv_technicien['surface_devis'] ?>" onFocus="this.value='';" step="0.01">
                    </div>
                    <div class="col-sm-4">
                        <label for="hauteur_devis" class="col-form-label">Hauteur en m :</label>
                    </div>
                    <div class="col-sm-8">
                        <input type="number" id="hauteur_devis" name="hauteur_devis" class="form-control" value="<?= $rdv_technicien['hauteur_devis'] ?>" onFocus="this.value='';" step="0.01">
                    </div>
                    <div class="col-sm-4">
                        <label for="volume_devis" class="col-form-label">Volume en m³ :</label>
                    </div>
                    <div class="col-sm-8">
                        <input type="number" id="volume_devis" name="volume_devis" class="form-control" step="0.0001" value="<?= $rdv_technicien['volume_devis']?>" disabled>
                        <!-- Pour permettre l'envoi du volume dans le formulaire -->
                        <input type="number" id="volume_devis2" step="0.0001" name="volume_devis2" value="<?= $rdv_technicien['volume_devis']?>" hidden>
                    </div>
                </div>
                <div class="d-flex justify-content-center mt-4">
                    <a href="compteRenduIntervention1.php?id_rdv=<?= $_GET['id_rdv'] ?>"><button type="submit" class="btn btn-success"><i class="far fa-check-circle me-2"></i>Valider les modifications</button></a>
                </div>
            </div>
        </div>
    </form>

<script src="js\nouveauDevis.js"></script>
<?php
include "footer.php";
?>