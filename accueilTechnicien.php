<?php
include "header.php";
session_start();
date_default_timezone_set('Europe/Paris');
echo "Nous sommes le " . date('d/m/Y') . " et il est " . date('H:i');
?>

<h3 class="text-center mt-3 mb-5">Bienvenue <?= $_SESSION["prenom_technicien"] . " " . $_SESSION["nom_technicien"] ?></h3>
<div id="explication">
    <p> Cette application est actuellement en cours de développement.</br> 
        C'est un des modules constituant l'ensemble de l'application (module client, module administration,...).</br>
        Les techniciens s'en serviront pour prendre leurs rendez-vous, faire des devis et facturer les clients après leurs interventions.</br> 
        Cette application est responsive design car elle sera principalement utilisé sur smartphone.</br>
        Afin d'éviter le rechargement des pages et accélerer la fluidité sur mobile, certaines d'entre elles ont des traitements asynchrones (AJAX) avec des modifications du DOM.</br>
        J'ai retirée certaines pages afin de garder la confidentialité du projet.</br> 
        Lorsque vous quittez l'application (bouton déconnexion), aucune donnée ne sera stockée.</br>
    </p>
    <div id="mode">
        <h4>Comment utiliser l'application :</h4>
        <ol>
            <li>Générez des rendez-vous</li>
            <li>Cliquez sur le menu "RDV de la semaine"</li>
            <li>Sélectionnnez un des rendez-vous</li>
            <li>Naviguez ensuite sur l'application, vous pourrez :</li>
                <ul>
                    <li>modifier les comptes-rendus</li>
                    <li>modifier le volume des pièces à traiter</li>
                    <li>facturer le client</li>
                </ul>
        </ol>
    </div>
   
</div>
<div class="d-grid gap-2 col-4 mx-auto my-6">
  <button id="genererRdv" class="btn btn-primary" type="submit">Générer des rendez-vous</button>
</div>

<script src="js\rdv.js"></script>
<?php
include "footer.php";
?>