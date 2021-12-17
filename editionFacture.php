<?php
session_start();  // Démarrage de la session pour avoir accès à '$_SESSION'
include "database.php";  // connexion à la bdd
$pdo = Database::connect();

// On vérifie que le technicien est bien en ligne
if (key_exists("prenom_technicien", $_SESSION) && key_exists("nom_technicien", $_SESSION)){
    // On récupère les informations du rdv, du technicien et du client en fonction de l'id du rdv
    $req = $pdo->prepare("SELECT g.*, d.id_devis, d.numero_devis, d.ttc_devis, d.acompte_devis FROM `t_gestion_rdv` AS g JOIN `t_clients` AS c ON fk_client_id = c.id_client JOIN `t_devis` AS d ON id_rdv = fk_gestion_rdv_id WHERE g.id_rdv = :id_rdv"); 
    $req->bindValue(":id_rdv", $_GET['id_rdv'], PDO::PARAM_INT);
    $req->execute();
    $facture_technicien = $req->fetch();
    
    $fk_client_id = $facture_technicien["fk_client_id"];
    $fk_technicien_id = $facture_technicien["fk_technicien_id"];
    $fk_gestion_rdv_id = $facture_technicien["id_rdv"];
    $fk_devis_id = $facture_technicien["id_devis"];
    $numero_facture = "F{$facture_technicien['numero_devis']}";
    $facture_ttc = $facture_technicien["ttc_devis"];
    $acompte_facture = $facture_technicien["acompte_devis"];
    
    //  On vérifie que la facture n'existe pas avant d'en créer une, si elle existe déjà, alors on mettra à jour l'existante
    // On récupère donc l'id de la facture
    $req = $pdo->prepare("SELECT id_facture FROM `t_factures` WHERE fk_gestion_rdv_id = :id_rdv");
    $req->bindValue(":id_rdv", $_GET['id_rdv'], PDO::PARAM_INT);
    $req->execute();
    $id_facture = $req->fetch();
     
    if(!$id_facture) {         
        //  Requête SQL permettant la création de la facture
        $req = $pdo->prepare("INSERT INTO `t_factures` (fk_client_id, fk_technicien_id, fk_gestion_rdv_id, fk_devis_id, numero_facture, facture_ttc, acompte_facture) VALUES (:fk_client_id, :fk_technicien_id, :fk_gestion_rdv_id, :fk_devis_id, :numero_facture, :facture_ttc, :acompte_facture)");
        $req->bindValue(":fk_client_id", $fk_client_id, PDO::PARAM_INT);
        $req->bindValue(":fk_technicien_id", $fk_technicien_id, PDO::PARAM_INT);
        $req->bindValue(":fk_gestion_rdv_id", $fk_gestion_rdv_id, PDO::PARAM_INT);
        $req->bindValue(":fk_devis_id", $fk_devis_id, PDO::PARAM_INT);
        $req->bindValue(":numero_facture", $numero_facture, PDO::PARAM_STR);
        $req->bindValue(":facture_ttc", $facture_ttc, PDO::PARAM_STR);
        $req->bindValue(":acompte_facture", $acompte_facture, PDO::PARAM_STR);
        $req->execute();
        // On récupère l'id de la facture qui vient d'être créee
        $req = $pdo->prepare("SELECT id_facture FROM `t_factures` WHERE fk_gestion_rdv_id = :id_rdv");
        $req->bindValue(":id_rdv", $_GET['id_rdv'], PDO::PARAM_INT);
        $req->execute();
        $id_facture = $req->fetch();
        echo "<script>window.location.href='compteRenduIntervention2.php?id_facture={$id_facture['0']}'</script>";
        Database::disconnect();
    } else {
        //  Requête SQL permettant la mise à jour de la facture
        $req = $pdo->prepare("UPDATE `t_factures` SET numero_facture = :numero_facture_facture, facture_ttc = :facture_ttc_facture, acompte_facture = :acompte_facture_facture WHERE id_facture = :id_facture_facture");
        $req->bindValue(":numero_facture_facture", $numero_facture, PDO::PARAM_STR);
        $req->bindValue(":facture_ttc_facture", $facture_ttc, PDO::PARAM_STR);
        $req->bindValue(":acompte_facture_facture", $acompte_facture, PDO::PARAM_STR);
        $req->bindValue(":id_facture_facture", $id_facture, PDO::PARAM_INT);
        $req->execute();        
        echo "<script>window.location.href='compteRenduIntervention2.php?id_facture={$id_facture['0']}'</script>";
        Database::disconnect();
    }
} else{
    echo "<script>window.location.href='disconnect.php'</script>";
}
?>