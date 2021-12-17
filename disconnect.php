<?php
include "database.php";
$pdo = Database::connect();
$date = date('Y/m/d', strtotime('-1 week'));
for ($i=0; $i < 5 ; $i++) {
    $id_rdv = $i+1; 
    $req = $pdo->prepare("UPDATE `t_gestion_rdv` SET date_gestion_rdv = :date_rdv WHERE id_rdv = :id_rdv");
    $req->bindValue(":date_rdv", $date, PDO::PARAM_STR);
    $req->bindValue(":id_rdv", $id_rdv, PDO::PARAM_INT);
    $req->execute();    
};
Database::disconnect();
session_start();
session_destroy();
session_unset();
header('Location:index.html');
?>