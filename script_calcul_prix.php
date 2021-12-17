<?php 

function particulier_formule1_calcul_prix($volume) {
    require 'requete_calcul_prix.php';
    for ($i=0; $i < count($table_bdd_tarifs_particuliers); $i++) { 
        if ($volume > $table_bdd_tarifs_particuliers[$i]["palier_volume_tarif_particulier"]) {
            $price = $table_bdd_tarifs_particuliers[$i]["intervention1_tarif_particulier"] + ($volume - $table_bdd_tarifs_particuliers[$i]["palier_volume_tarif_particulier"]) * $table_bdd_tarifs_particuliers[$i]["formule1_tarif_particulier"];
            // $duree = $table_bdd_tarifs_entreprises[$i]["duree_rdv_formule_1_tarif_particulier"];
        }else {
            $price = $table_bdd_tarifs_particuliers[0]["intervention1_tarif_particulier"];
        }
    }
    $price = number_format((float)$price, 2, ',', '');
    return $price;
}

function particulier_formule1_calcul_temps($volume) {
    require 'requete_calcul_prix.php';
    for ($i=0; $i < count($table_bdd_tarifs_particuliers); $i++) { 
        if ($volume > $table_bdd_tarifs_particuliers[$i]["palier_volume_tarif_particulier"]) {
            $duree = substr($table_bdd_tarifs_particuliers[$i][6], 0, 5);
        } else {
            $duree = substr($table_bdd_tarifs_particuliers[0][6], 0, 5);
        }
    }
    return $duree;
}

function particulier_formule2_calcul_prix($volume) {
    require 'requete_calcul_prix.php';
    $res = array();
    for ($i=0; $i < count($table_bdd_tarifs_particuliers); $i++) { 
        if ($volume > $table_bdd_tarifs_particuliers[$i]["palier_volume_tarif_particulier"]) {
            $price = $table_bdd_tarifs_particuliers[$i]["intervention2_tarif_particulier"] + ($volume - $table_bdd_tarifs_particuliers[$i]["palier_volume_tarif_particulier"]) * $table_bdd_tarifs_particuliers[$i]["formule2_tarif_particulier"];
        } else {
            $price = $table_bdd_tarifs_particuliers[0]["intervention2_tarif_particulier"];
        }
    }
    $price = number_format((float)$price, 2, ',', '');
    return $price;
}

function particulier_formule2_calcul_temps($volume) {
    require 'requete_calcul_prix.php';
    for ($i=0; $i < count($table_bdd_tarifs_particuliers); $i++) { 
        if ($volume > $table_bdd_tarifs_particuliers[$i]["palier_volume_tarif_particulier"]) {
            $duree = substr($table_bdd_tarifs_particuliers[$i][7], 0, 5);
        } else {
            $duree = substr($table_bdd_tarifs_particuliers[0][7], 0, 5);
        }
    }
    return $duree;
}

function entreprise_formule1_calcul_prix($volume) {
    require 'requete_calcul_prix.php';
    $res = array();
    for ($i=0; $i < count($table_bdd_tarifs_entreprises); $i++) {
        if ($volume > $table_bdd_tarifs_entreprises[$i]["palier_volume_tarif_entreprise"]) {
            $price = $table_bdd_tarifs_entreprises[$i]["intervention1_tarif_entreprise"] + ($volume - $table_bdd_tarifs_entreprises[$i]["palier_volume_tarif_entreprise"]) * $table_bdd_tarifs_entreprises[$i]["formule2_tarif_entreprise"];
        } else {
            $price = $table_bdd_tarifs_entreprises[0]["intervention1_tarif_entreprise"];
        }
    }
    $price = number_format((float)$price, 2, ',', '');
    return $price;
}

function entreprise_formule1_calcul_temps($volume) {
    require 'requete_calcul_prix.php';
    for ($i=0; $i < count($table_bdd_tarifs_particuliers); $i++) { 
        if ($volume > $table_bdd_tarifs_particuliers[$i]["palier_volume_tarif_particulier"]) {
            $duree = substr($table_bdd_tarifs_entreprises[$i][6], 0, 5);
        } else {
            $duree = substr($table_bdd_tarifs_entreprises[0][6], 0, 5);
        }
    }
    return $duree;
}

function entreprise_formule2_calcul_prix($volume) {
    require 'requete_calcul_prix.php';
    $res = array();
    for ($i=0; $i < count($table_bdd_tarifs_entreprises); $i++) { 
        if ($volume > $table_bdd_tarifs_entreprises[$i]["palier_volume_tarif_entreprise"]) {
            $price = $table_bdd_tarifs_entreprises[$i]["intervention2_tarif_entreprise"] + ($volume - $table_bdd_tarifs_entreprises[$i]["palier_volume_tarif_entreprise"]) * $table_bdd_tarifs_entreprises[$i]["formule2_tarif_entreprise"];
        } else {
            $price = $table_bdd_tarifs_entreprises[0]["intervention2_tarif_entreprise"];
        }
    }
    $price = number_format((float)$price, 2, ',', '');
    return $price;
}

function entreprise_formule2_calcul_temps($volume) {
    require 'requete_calcul_prix.php';
    for ($i=0; $i < count($table_bdd_tarifs_particuliers); $i++) { 
        if ($volume > $table_bdd_tarifs_particuliers[$i]["palier_volume_tarif_particulier"]) {
            $duree = substr($table_bdd_tarifs_entreprises[$i][7], 0, 5);
        } else {
            $duree = substr($table_bdd_tarifs_entreprises[0][7], 0, 5);
        }
    }
    return $duree;
}

function prix_Intervention($volume, $cat, $traitement) {
    if ($cat = "Particulier") {
        if ($traitement == "Destruction Virus/Bactéries") {
            $prix = particulier_formule1_calcul_prix($volume);
        } else {
            $prix = particulier_formule2_calcul_prix($volume);
        }
    } else {
        if ($traitement == "Destruction Virus/Bactéries") {
            $prix = entreprise_formule1_calcul_prix($volume);
        } else {
            $prix = entreprise_formule2_calcul_prix($volume);
        }
    }
    return $prix;
}

function temps_Intervention($volume, $cat, $traitement) {
    if ($cat = "Particulier") {
        if ($traitement == "Destruction Virus/Bactéries") {
            $temps = particulier_formule1_calcul_temps($volume);
        } else {
            $temps = particulier_formule2_calcul_temps($volume);
        }
    } else {
        if ($traitement == "Destruction Virus/Bactéries") {
            $temps = entreprise_formule1_calcul_temps($volume);
        } else {
            $temps = entreprise_formule2_calcul_temps($volume);
        }
    }
    return $temps;
}

?>