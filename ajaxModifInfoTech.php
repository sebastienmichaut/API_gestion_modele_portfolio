<?php
session_start();
include "database.php";
    if ($_POST) {  // Si le formulaire est posté
        if (key_exists("prenom_technicien", $_SESSION) && key_exists("nom_technicien", $_SESSION)){ // On vérifie que le technicien est bien connecté
            if ($_POST["mail_technicien"]) { 
                if (filter_var($_POST["mail_technicien"], FILTER_VALIDATE_EMAIL)){ // On vérifie que l'email est au bon format
                    if((strlen($_POST["CP_technicien"]) == 5) && (strlen($_POST["tel_technicien"]) == 10)){ // Quelques vérifications supplémentaires 
                        $pdo = Database::connect(); //On se connecte à la bdd
                        $req = $pdo->prepare("UPDATE `t_techniciens` SET 
                            voie_technicien = :voie_technicien,
                            CP_technicien = :CP_technicien,
                            ville_technicien = :ville_technicien,
                            tel_technicien = :tel_technicien,
                            mail_technicien = :mail_technicien WHERE id_technicien = :id_technicien;");
                        $voie_technicien = htmlspecialchars($_POST["voie_technicien"]);
                        $cp_technicien = htmlspecialchars($_POST["CP_technicien"]);
                        $ville_technicien = htmlspecialchars($_POST["ville_technicien"]);
                        $tel_technicien =htmlspecialchars($_POST["tel_technicien"]);
                        $mail_technicien = htmlspecialchars($_POST["mail_technicien"]);
                        $req->bindValue(":voie_technicien", $voie_technicien, PDO::PARAM_STR);
                        $req->bindValue(":CP_technicien", $cp_technicien, PDO::PARAM_STR_CHAR);
                        $req->bindValue(":ville_technicien", $ville_technicien, PDO::PARAM_STR);
                        $req->bindValue(":tel_technicien", $tel_technicien, PDO::PARAM_STR);
                        $req->bindValue(":mail_technicien", $mail_technicien, PDO::PARAM_STR);
                        $req->bindValue(":id_technicien", $_SESSION["id_technicien"], PDO::PARAM_INT);
                        $req->execute();
                        echo json_encode("Infos ok"); // On renvoie une réponse à l'API Fetch() sur le fichier modifInfoTech.js pour informer que les données sont bien en bdd
                        Database::disconnect();
                    } else {
                        echo json_encode("erreur1"); // On renvoie une réponse correspondant à une erreur que l'API fetch affichera dans le navigateur
                    }
                } else {
                    echo json_encode("erreur2");
                }
            } else {
                echo json_encode("erreur3");
            }
        } else{
            echo json_encode("erreur4");
        }
    }
?>