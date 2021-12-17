    <?php

    include "database.php";  // connexion à la bdd
    $pdo = Database::connect();
    // On récupère les informations du devis en fonction de l'id du rdv
    $req = $pdo->query("SELECT g.ID_rdv, d.numero_devis, d.ttc_devis, d.acompte_devis FROM `t_gestion_rdv` AS g JOIN `t_devis` AS d ON fk_gestion_rdv_id = g.id_rdv WHERE g.id_rdv = '{$_GET['id_rdv']}'"); 
    $infos_devis = $req->fetch();
    $infos_devis =['numero_devis' => $infos_devis["numero_devis"], 'ttc_devis' => $infos_devis["ttc_devis"], 'acompte_devis' => $infos_devis["acompte_devis"]];
    echo json_encode($infos_devis); // On renvoie les données (à compterenduIntervention1.js)
    Database::disconnect();

    ?>