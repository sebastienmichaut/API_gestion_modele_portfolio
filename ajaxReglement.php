<?php
session_start();  // Démarrage de la session pour avoir accès à '$_SESSION'
include "database.php";  // connexion à la bdd
$pdo = Database::connect();

// On vérifie que le technicien est bien en ligne
if (key_exists("prenom_technicien", $_SESSION) && key_exists("nom_technicien", $_SESSION)){
    // Si le formulaire est soumis
    if ($_POST) {
        // On vérifie si c'est la CB qui doit être enregistré
        if(isset($_POST["num_transaction_facture"])){
            if(is_numeric($_POST["num_transaction_facture"]) && (is_numeric($_POST["montant_CB_facture"]))){
                $req = $pdo->prepare("UPDATE `t_factures` SET num_transaction_facture = :num_transaction_facture, montant_CB_facture = :montant_CB_facture WHERE id_facture = :id_facture"); // Requête SQL permettant l'enregistrement du règlement par CB en BDD
                $req->bindValue(":num_transaction_facture", $_POST["num_transaction_facture"], PDO::PARAM_STR);
                $req->bindValue(":montant_CB_facture", $_POST["montant_CB_facture"], PDO::PARAM_INT);
                $req->bindValue(":id_facture", $_GET["id_facture"], PDO::PARAM_INT);
                $req->execute();
                echo "CB"; // On renvoie une réponse à l'appel Ajax ( sur compteRenduIntervention2.js )
            }else {
                echo "Erreur"; // On renvoie une réponse à l'appel Ajax ( sur compteRenduIntervention2.js )
            }           
        }else if(isset($_POST["num_cheque_facture"])){ // On vérifie si c'est le chèque qui doit être enregistré
            if(is_numeric($_POST["num_cheque_facture"]) && is_numeric($_POST["montant_cheque_facture"]) && is_numeric($_POST["num_ci_facture"])){
                $req = $pdo->prepare("UPDATE `t_factures`SET num_cheque_facture = :num_cheque_facture, montant_cheque_facture = :montant_cheque_facture, num_ci_facture = :num_ci_facture, date_ci_facture = :date_ci_facture, prefecture_ci_facture =:prefecture_ci_facture WHERE id_facture = :id_facture"); // Requête SQL permettant l'enregistrement du règlement par chèque en BDD
                $req->bindValue(":num_cheque_facture", $_POST["num_cheque_facture"], PDO::PARAM_INT);
                $req->bindValue(":montant_cheque_facture", $_POST["montant_cheque_facture"], PDO::PARAM_INT);
                $req->bindValue(":num_ci_facture", $_POST["num_ci_facture"], PDO::PARAM_INT);
                $req->bindValue(":date_ci_facture", $_POST["date_ci_facture"], PDO::PARAM_STR);
                $req->bindValue(":prefecture_ci_facture", $_POST["prefecture_ci_facture"], PDO::PARAM_STR);
                $req->bindValue(":id_facture", $_GET["id_facture"], PDO::PARAM_INT);
                $req->execute();
                echo "Cheque"; // On renvoie une réponse à l'appel Ajax ( sur compteRenduIntervention2.js )
            }
        }else {
            echo "Erreur"; // On renvoie une réponse à l'appel Ajax ( sur compteRenduIntervention2.js )
        }
    }
    Database::disconnect();
}else {
    echo "<script>window.location.href='disconnect.php'</script>";
}
?>