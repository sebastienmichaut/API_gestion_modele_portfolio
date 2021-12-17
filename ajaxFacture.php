<?php
session_start();  // Démarrage de la session pour avoir accès à '$_SESSION'
include "database.php";  // connexion à la bdd
$pdo = Database::connect();

// On vérifie que le technicien est bien en ligne
if (key_exists("prenom_technicien", $_SESSION) && key_exists("nom_technicien", $_SESSION)){
    // On récupère l'id de la facture
    $req = $pdo->prepare("SELECT id_facture FROM `t_factures` WHERE fk_gestion_rdv_id = :id_rdv");
    $req->bindValue(":id_rdv", $_GET['id_rdv'], PDO::PARAM_INT);
    $req->execute();
    $id_facture = $req->fetch();
    if (($id_facture)){
        // On renvoie les données (à compterenduIntervention1.js) en lui disant si il existe une facture et si oui, on lui renvoie l'id de celle-ci
        $infos_facture =['resultat' => "Facture presente", 'id_facture' => $id_facture['0']];
        echo json_encode($infos_facture);
    } else{
        $infos_facture =['resultat' => "Pas de facture"];
        echo json_encode($infos_facture);        
    }
    Database::disconnect();
} else{
    echo "<script>window.location.href='disconnect.php'</script>";
}
?>