<?php

$pdo = Database::connect();
    $table_bdd_tarifs_particuliers = array();
    $i = 0;
    $query = $pdo->query("SELECT * FROM t_tarifs_particuliers;");
    //remplissage du tableau des tarifs pour particuliers
    while ($data = $query->fetch()) {
        $table_bdd_tarifs_particuliers[$i] = $data;
        $i = $i+1;
    }

    $table_bdd_tarifs_entreprises = array();
    $i = 0;
    $query = $pdo->query("SELECT * FROM t_tarifs_entreprises;");
    //remplissage du tableau des tarifs pour entreprises
    while ($data = $query->fetch()) {
        $table_bdd_tarifs_entreprises[$i] = $data;
        $i = $i+1;
    }
Database::disconnect();
?>