<?php
include "database.php";
$pdo = Database::connect();
date_default_timezone_set('Europe/Paris');
$dateJour = date('d/m/Y H:i');
if ($_POST){
    $req = $pdo->query("SELECT `date_gestion_rdv`, `id_rdv` FROM `t_gestion_rdv`"); 
    $data = $req->fetchAll();
    
    $today = time();
    $time = $today;
    for ($i=0; $i < sizeof($data); $i++) { 
        if ($i<4){
            $time += 86400;
            $date[$i][0] = date('Y/m/d',$time);
            $data[$i][0] = $date[$i][0];
        } else {
            $time -= 86400;
            $date[$i][0] = date('Y/m/d',$time);
            $data[$i][0] = $date[$i][0];
        }
        $date_rdv = $data[$i][0];
        $id_rdv = $i+1; 
        $req = $pdo->prepare("UPDATE `t_gestion_rdv` SET date_gestion_rdv = :date_rdv WHERE id_rdv = :id_rdv");
        $req->bindValue(":date_rdv", $date_rdv, PDO::PARAM_STR);
        $req->bindValue(":id_rdv", $id_rdv, PDO::PARAM_INT);
        $req->execute();
    }
    $jour = date('Y-m-d');
    $req = $pdo->query("SELECT `date_gestion_rdv` FROM t_gestion_rdv WHERE id_rdv = 1");
    $dateDevis = $req->fetch();
    $dateDevis = $dateDevis[0];
    if ($jour < $dateDevis) {
        echo "ok";
        Database::disconnect();
    }else{
        echo "erreur1";
        Database::disconnect();
    }
    
} else {
    echo "erreur2";
    Database::disconnect();
}