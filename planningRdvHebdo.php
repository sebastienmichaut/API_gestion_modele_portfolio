<?php
session_start();  // Démarrage de la session pour avoir accès à '$_SESSION'
include "header.php"; 
include "database.php";  // connexion à la bdd
$pdo = Database::connect();
    $table_bdd_gestion_rdv = array();
    $i = 0;
    $query = $pdo->query("SELECT * FROM t_gestion_rdv WHERE fk_technicien_id = {$_SESSION['id_technicien']};");
    //remplissage du tableau de gestion des rdv
    while ($data = $query->fetch()) {
        $table_bdd_gestion_rdv[$i] = $data;
        $i = $i+1;
    }

setlocale(LC_TIME,'fr', 'fr_FR', 'fr_FR.ISO8859-1');
date_default_timezone_set('Europe/Paris');
$jours = array("Lundi", "Mardi", "Mercredi","Jeudi", "Vendredi", "Samedi", "Dimanche"); //Tableau pour afficher les jours en français
$today = intval(date('w')) - 1;
?>
    <div id="planning">
        <div class="container-calendar" id="container-calendar">
        <p class="titre-h">Votre semaine de RDV</p><br>
            <div class="input-none">
            <?php
                echo '<div id="calendar">';
                //Affichage du planning des créneaux commencant au lundi de la semaine actuelle
                for ($i=0; $i < 56 ; $i++) { 
                    $day = $jours[($i)%7]; //Définition du jour de la semaine
                    if ($i == 0) {
                        echo '<div class="semaine" id="semaine">'; //Si c'est la première semaine alors elle est affichée sinon les autres sont masquées pour permettre le défilement
                    } elseif ($day == 'Lundi' && $i != 0) { 
                        echo '<div class="semaine" id="semaine">';
                    }
                    echo "<div class='jour' id='jour'>";
                    $date = new DateTime('now +'. ($i - $today) .' days'); //Date du jour affiché
                    $auj = new DateTime('now'); //Date d'aujourd'hui
                    echo '<span>';
                    echo $day;
                    echo '</span>';
                    echo '<span>';
                    echo $date->format('d/m/Y');
                    echo '</span>';
                    $busyday = false;
                    $booked =false;
                    $rdv = array();
                    for ($j=0; $j < count($table_bdd_gestion_rdv); $j++) { //Boucle vérifiant si un créneau est pris en fonction des données de la BDD 
                        if ($table_bdd_gestion_rdv[$j]["date_gestion_rdv"] == $date->format('Y-m-d')) {
                            $busyday = $table_bdd_gestion_rdv[$j]["lieu_rdv_gestion_rdv"];
                            $booked = $table_bdd_gestion_rdv[$j]["heure_debut_gestion_rdv"];
                            $id_rdv = $table_bdd_gestion_rdv[$j]["id_rdv"];
                            $int_heure = intval(substr($booked,0,2));
                            $rdv[$int_heure]["lieu"] = $busyday;
                            $rdv[$int_heure]["id_rdv"] = $id_rdv;
                            $rdv[$int_heure]["heure"] = $int_heure;
                            $rdv[$int_heure + 1]["lieu"] = $busyday;
                            $rdv[$int_heure + 1]["id_rdv"] = $id_rdv;
                            $rdv[$int_heure + 1]["heure"] = $int_heure;
                        }
                    }
                        //Affichage des créneaux horaires
                        ?>
            <div class="creneau">                
                <a <?php if (!empty($rdv[6])) {echo "class='horaire text-dark text-center border border-dark rounded-pill px-1 my-1'"; echo "href='detailsRdvTechnicien.php?id_rdv=".$rdv[6]['id_rdv']."'";}?> id="<?php echo $i ?>-6h" class="horaire" name="dateRDV" value="<?php echo($date->format("Y-m-d"))." 6" ?>">
                    <label for="<?php echo $i ?>-6h"><?php if (!empty($rdv[6])) {echo $rdv[6]["heure"]."h ";echo $rdv[6]["lieu"];} else {echo"6h - 7h";} ?></label>
                </a>
            </div>

            <div class="creneau">
                <a <?php if (!empty($rdv[7])) {echo "class='horaire text-dark text-center border border-dark rounded-pill px-1 my-1'"; echo "href='detailsRdvTechnicien.php?id_rdv=".$rdv[7]['id_rdv']."'";}?> id="<?php echo $i ?>-7h" class="horaire" name="dateRDV" value="<?php echo($date->format("Y-m-d"))." 7" ?>">
                    <label for="<?php echo $i ?>-7h"><?php if (!empty($rdv[7])) {echo $rdv[7]["heure"]."h ";echo $rdv[7]["lieu"];} else {echo"7h - 8h";} ?> </label>
                </a>
            </div>

            <div class="creneau">
                <a <?php if (!empty($rdv[8])) {echo "class='horaire text-dark text-center border border-dark rounded-pill px-1 my-1'"; echo "href='detailsRdvTechnicien.php?id_rdv=".$rdv[8]['id_rdv']."'";}?> id="<?php echo $i ?>-8h" class="horaire" name="dateRDV" value="<?php echo($date->format("Y-m-d"))." 8" ?>">
                    <label for="<?php echo $i ?>-8h"><?php if (!empty($rdv[8])) {echo $rdv[8]["heure"]."h ";echo $rdv[8]["lieu"];} else {echo"8h - 9h";} ?></label>
                </a>
            </div>

            <div class="creneau">
                <a <?php if (!empty($rdv[9])) {echo "class='horaire text-dark text-center border border-dark rounded-pill px-1 my-1'"; echo "href='detailsRdvTechnicien.php?id_rdv=".$rdv[9]['id_rdv']."'";}?> id="<?php echo $i ?>-9h" class="horaire" name="dateRDV" value="<?php echo($date->format("Y-m-d"))." 9" ?>">
                    <label for="<?php echo $i ?>-9h"><?php if (!empty($rdv[9])) {echo $rdv[9]["heure"]."h ";echo $rdv[9]["lieu"];} else {echo"9h - 10h";} ?> </label>
                </a>
            </div>

            <div class="creneau">   
                <a <?php if (!empty($rdv[10])) {echo "class='horaire text-dark text-center border border-dark rounded-pill px-1 my-1'"; echo "href='detailsRdvTechnicien.php?id_rdv=".$rdv[10]['id_rdv']."'";}?> id="<?php echo $i ?>-10h" class="horaire" name="dateRDV" value="<?php echo($date->format("Y-m-d"))." 10" ?>">
                    <label for="<?php echo $i ?>-10h"><?php if (!empty($rdv[10])) {echo $rdv[10]["heure"]."h ";echo $rdv[10]["lieu"];} else {echo"10h - 11h";} ?></label>
                </a>
            </div>

            <div class="creneau">    
                <a <?php if (!empty($rdv[11])) {echo "class='horaire text-dark text-center border border-dark rounded-pill px-1 my-1'"; echo "href='detailsRdvTechnicien.php?id_rdv=".$rdv[11]['id_rdv']."'";}?> id="<?php echo $i ?>-11h" class="horaire" name="dateRDV" value="<?php echo($date->format("Y-m-d"))." 11" ?>">
                    <label for="<?php echo $i ?>-11h"><?php if (!empty($rdv[11])) {echo $rdv[11]["heure"]."h ";echo $rdv[11]["lieu"];} else {echo"11h - 12h";} ?></label>
                </a>
            </div>

            <div class="creneau">
                 <a <?php if (!empty($rdv[12])) {echo "class='horaire text-dark text-center border border-dark rounded-pill px-1 my-1'"; echo "href='detailsRdvTechnicien.php?id_rdv=".$rdv[12]['id_rdv']."'";}?> id="<?php echo $i ?>-12h" class="horaire" name="dateRDV" value="<?php echo($date->format("Y-m-d"))." 12" ?>">
                    <label for="<?php echo $i ?>-12h"><?php if (!empty($rdv[12])) {echo $rdv[12]["heure"]."h ";echo $rdv[12]["lieu"];} else {echo"12h - 13h";} ?></label>
                </a>
            </div>

            <div class="creneau">
                <a <?php if (!empty($rdv[13])) {echo "class='horaire text-dark text-center border border-dark rounded-pill px-1 my-1'"; echo "href='detailsRdvTechnicien.php?id_rdv=".$rdv[13]['id_rdv']."'";}?> id="<?php echo $i ?>-13h" class="horaire" name="dateRDV" value="<?php echo($date->format("Y-m-d"))." 13" ?>">
                    <label for="<?php echo $i ?>-13h"><?php if (!empty($rdv[13])) {echo $rdv[13]["heure"]."h ";echo $rdv[13]["lieu"];} else {echo"13h - 14h";} ?></label>
                </a>
            </div>

            <div class="creneau">
                <a <?php if (!empty($rdv[14])) {echo "class='horaire text-dark text-center border border-dark rounded-pill px-1 my-1'"; echo "href='detailsRdvTechnicien.php?id_rdv=".$rdv[14]['id_rdv']."'";}?> id="<?php echo $i ?>-14h" class="horaire" name="dateRDV" value="<?php echo($date->format("Y-m-d"))." 14" ?>">
                    <label for="<?php echo $i ?>-14h"><?php if (!empty($rdv[14])) {echo $rdv[14]["heure"]."h ";echo $rdv[14]["lieu"];} else {echo"14h - 15h";} ?></label>
                </a>
            </div>

            <div class="creneau">
                <a <?php if (!empty($rdv[15])) {echo "class='horaire text-dark text-center border border-dark rounded-pill px-1 my-1'"; echo "href='detailsRdvTechnicien.php?id_rdv=".$rdv[15]['id_rdv']."'";}?> id="<?php echo $i ?>-15h" class="horaire" name="dateRDV" value="<?php echo($date->format("Y-m-d"))." 15" ?>">
                    <label for="<?php echo $i ?>-15h"><?php if (!empty($rdv[15])) {echo $rdv[15]["heure"]."h ";echo $rdv[15]["lieu"];} else {echo"15h - 16h";} ?></label>
                </a>
            </div>

            <div class="creneau">
                <a <?php if (!empty($rdv[16])) {echo "class='horaire text-dark text-center border border-dark rounded-pill px-1 my-1'"; echo "href='detailsRdvTechnicien.php?id_rdv=".$rdv[16]['id_rdv']."'";}?> id="<?php echo $i ?>-16h" class="horaire" name="dateRDV" value="<?php echo($date->format("Y-m-d"))." 16" ?>">
                    <label for="<?php echo $i ?>-16h"><?php if (!empty($rdv[16])) {echo $rdv[16]["heure"]."h ";echo $rdv[16]["lieu"];} else {echo"16h - 17h";} ?></label>
                </a>
            </div>

            <div class="creneau">
                <a <?php if (!empty($rdv[17])) {echo "class='horaire text-dark text-center border border-dark rounded-pill px-1 my-1'"; echo "href='detailsRdvTechnicien.php?id_rdv=".$rdv[17]['id_rdv']."'";}?> id="<?php echo $i ?>-17h" class="horaire" name="dateRDV" value="<?php echo($date->format("Y-m-d"))." 17" ?>">
                    <label for="<?php echo $i ?>-17h"><?php if (!empty($rdv[17])) {echo $rdv[17]["heure"]."h ";echo $rdv[17]["lieu"];} else {echo"17h - 18h";} ?></label>
                </a>
            </div>

            <div class="creneau">
                <a <?php if (!empty($rdv[18])) {echo "class='horaire text-dark text-center border border-dark rounded-pill px-1 my-1'"; echo "href='detailsRdvTechnicien.php?id_rdv=".$rdv[18]['id_rdv']."'";}?> id="<?php echo $i ?>-18h" class="horaire" name="dateRDV" value="<?php echo($date->format("Y-m-d"))." 18" ?>">
                    <label for="<?php echo $i ?>-18h"><?php if (!empty($rdv[18])) {echo $rdv[18]["heure"]."h ";echo $rdv[18]["lieu"];} else {echo"18h - 19h";} ?></label>
                </a>
            </div>

            <div class="creneau">
                <a <?php if (!empty($rdv[19])) {echo "class='horaire text-dark text-center border border-dark rounded-pill px-1 my-1'"; echo "href='detailsRdvTechnicien.php?id_rdv=".$rdv[19]['id_rdv']."'";}?> id="<?php echo $i ?>-19h" class="horaire" name="dateRDV" value="<?php echo($date->format("Y-m-d"))." 19" ?>">
                    <label for="<?php echo $i ?>-19h"><?php if (!empty($rdv[19])) {echo $rdv[19]["heure"]."h ";echo $rdv[19]["lieu"];} else {echo"19h - 20h";} ?></label>
                </a>
            </div>

            <div class="creneau">
                <a <?php if (!empty($rdv[20])) {echo "class='horaire text-dark text-center border border-dark rounded-pill px-1 my-1'"; echo "href='detailsRdvTechnicien.php?id_rdv=".$rdv[20]['id_rdv']."'";}?> id="<?php echo $i ?>-20h" class="horaire" name="dateRDV" value="<?php echo($date->format("Y-m-d"))." 20" ?>">
                    <label for="<?php echo $i ?>-20h"><?php if (!empty($rdv[20])) {echo $rdv[20]["heure"]."h ";echo $rdv[20]["lieu"];} else {echo"20h - 21h";} ?></label>
                </a>
            </div>
            
            <?php
                    echo "</div>";
                    if ($day == 'Dimanche') {
                        echo '</div>';
                    }
                }
                echo '</div>';
                ?>
        </div>
        <?php //bouttons permettant de défiler de semaine en semaine ?>
        <div class="container-end">
            <div class="changep">
                <button class="presui precW" type="button" id="prevWbutton" onclick="previous()" disabled></button>
                <label for="prevWbutton">Semaine <br> Précédente</label>
                <button class="presui precD day" type="button" id="prevDbutton" onclick="previousDay()" disabled></button>
                <label for="prevDbutton">Jour<br> Précédent</label>

                <button class="presui suivD day" type="button" id="nextDbutton" onclick="nextDay()"></button>
                <label for="nextDbutton">Jour<br> Suivant</label>
                <button class="presui suivW" type="button" id="nextWbutton" onclick="next()"></button>
                <label for="nextWbutton">Semaine<br> Suivante</label>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="js\planning.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>