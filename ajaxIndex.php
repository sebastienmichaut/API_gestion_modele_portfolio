<?php
include "database.php";
if ($_POST) {    // Si le formulaire html à été soumis
    $prenom_technicien = htmlspecialchars($_POST["prenom_technicien"]);
    $nom_technicien = htmlspecialchars($_POST["nom_technicien"]);
    $motDePasse_technicien = htmlspecialchars($_POST["motDePasse_technicien"]);
    if (strlen($prenom_technicien) > 2 && strlen($prenom_technicien) < 51 && strlen($nom_technicien) > 2 && strlen($nom_technicien) < 51 && strlen($motDePasse_technicien) > 7 && strlen($motDePasse_technicien) < 51) {  // Validation de la taille du prénom, nom et du mot de passe                                               
        $pdo = Database::connect();
        $req = $pdo->prepare("SELECT * FROM `t_techniciens` WHERE prenom_technicien=:prenom_technicien AND nom_technicien=:nom_technicien");   // Récupération (s'il existe) du technicien qui correspond au nom et prénom saisi 
        $req->bindValue(":prenom_technicien", $prenom_technicien, PDO::PARAM_STR);
        $req->bindValue(":nom_technicien", $nom_technicien, PDO::PARAM_STR);
        $req->execute();
        $technicien = $req->fetch();
        if ($technicien && password_verify($motDePasse_technicien, $technicien["motdepasse_technicien"])) {
            session_start();  // On connecte le technicien en passant son nom, son prénom et son ID dans la session
            $_SESSION["prenom_technicien"] = $prenom_technicien;
            $_SESSION["nom_technicien"] = $nom_technicien;
            $_SESSION["id_technicien"] = $technicien["id_technicien"];
            echo "ok";
        } else {  // Affichage du message d'erreur associé à la validation (index.js récupère ce message)
            echo "Erreur1";
        }
        Database::disconnect();
    } else {  // Affichage du message d'erreur associé à la validation (index.js récupère ce message)
        echo "Erreur2";
    }
}
?>