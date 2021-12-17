<?php
include "database.php";
if ($_POST) {     // Si le formulaire HTML a été soumis
    $prenom_technicien = htmlspecialchars($_POST["prenom_technicien"]);
    $nom_technicien = htmlspecialchars($_POST["nom_technicien"]);
    $motDePasse_technicien = htmlspecialchars($_POST["motDePasse_technicien"]);
    $confirmerMotDePasse_technicien = htmlspecialchars($_POST["confirmerMotDePasse_technicien"]);
    if ($motDePasse_technicien === $confirmerMotDePasse_technicien) {  
        if (strlen($prenom_technicien) > 2 && strlen($prenom_technicien) < 51 && strlen($nom_technicien) > 2 && strlen($nom_technicien) < 51 && strlen($motDePasse_technicien) > 7 && strlen($motDePasse_technicien) < 51) {  // Validation de la taille du prénom, nom et du mot de passe 
            $pdo = Database::connect();
            $req = $pdo->prepare("SELECT id_technicien FROM `t_techniciens` WHERE prenom_technicien=:prenom_technicien AND nom_technicien=:nom_technicien");   // Récupération (s'il existe) du technicien qui correspond au nom et prénom saisi 
            $req->bindValue(":prenom_technicien", $prenom_technicien, PDO::PARAM_STR);
            $req->bindValue(":nom_technicien", $nom_technicien, PDO::PARAM_STR);
            $req->execute();
            $technicien = $req->fetch();
            if($technicien) {            // Si le nom existe déjà en BDD, affichage d'un message d'erreur (creerCompteTechnicien.js récupère l'info)
                echo "Erreur1";
            } else {
                $cryptageMotDePasse = password_hash($motDePasse_technicien, PASSWORD_DEFAULT);       // Hashage du mot de passe 
                $req = $pdo->prepare("INSERT INTO `t_techniciens` (prenom_technicien, nom_technicien, motdepasse_technicien) VALUES (:prenom_technicien, :nom_technicien, :motdepasse_technicien)"); // Requête SQL permettant l'insertion du technicien en BDD
                $req->bindValue(":prenom_technicien", $prenom_technicien, PDO::PARAM_STR);
                $req->bindValue(":nom_technicien", $nom_technicien, PDO::PARAM_STR);
                $req->bindValue(":motdepasse_technicien", $cryptageMotDePasse, PDO::PARAM_STR);
                $req->execute();
                $req = $pdo->query("SELECT * FROM `t_techniciens` WHERE prenom_technicien='{$prenom_technicien}' AND nom_technicien='{$nom_technicien}'");
                $technicien = $req->fetch();
                session_start();     // On connecte le technicien en passant son nom, son prénom et son ID dans la session
                $_SESSION["prenom_technicien"] = $prenom_technicien;
                $_SESSION["nom_technicien"] = $nom_technicien;
                $_SESSION["id_technicien"] = $technicien["id_technicien"];
            }
        } else {  // Affichage du message d'erreur associé à la validation (creerCompteTechnicien.js récupère l'info)
            echo "Erreur2";
        }
    } else {  // Affichage du message d'erreur associé à la validation (creerCompteTechnicien.js récupère l'info)
        echo "Erreur3";
    }
    Database::disconnect();                                                    
}       
?>