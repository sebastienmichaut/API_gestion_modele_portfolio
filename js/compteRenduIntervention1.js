// Pour être certain que le DOM est chargé
$(document).ready(function () {

    function getParameterByName(name, url = window.location.href) {
        name = name.replace(/[\[\]]/g, "\\$&");
        var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
        if (!results) return null;
        if (!results[2]) return "";
        return decodeURIComponent(results[2].replace(/\+/g, " "));
    }
    
    // Evenement du bouton valider Volume
    $("#validerVolume").click(function(){
        // On récupère le numéro du rdv passé dans l'url
        var id_rdv = getParameterByName('id_rdv');
        // On modifie le DOM pour afficher le devis final
        $("#titreH4").text("DETAILS");
        $("#titreH5").text("Devis Final");
        $("#container").prepend('<dd id="numeroDevis" class="col-sm-8 bleu"></dd>');
        $("#container").prepend('<dt class="col-sm-4">Numéro de devis :</dt>');
        $("#container").append('<dt class="col-sm-4 mt-1">TTC Devis en € :</dt>');
        $("#container").append('<dd id="ttcDevis" class="col-sm-8 mt-1 jaune2"></dd>')
        $("#container").append('<dt class="col-sm-4 mt-1">Acompte en € :</dt>');
        $("#container").append('<dd id="acompte" class="col-sm-8 mt-1 jaune2"></dd>');
        $("#boutonDynamique").empty();
        $("#boutonDynamique").removeClass("d-flex justify-content-between mt-4").addClass("d-flex justify-content-center mt-4")
        $("#boutonDynamique").append('<button type="button" id="facture" class="btn btn-success"><i class="far fa-newspaper me-2"></i>Edition facture</button>');

        // Appel Ajax, on passe dans la requete, le numero du devis dans l'url
        $.get("ajaxCompteRendu.php?id_rdv=" + (id_rdv), function(data){
            //  On récupère les données JSON de PHP 
            var devis = $.parseJSON(data);
            // On passe les valeurs dans les champs html
            $("#numeroDevis").text(devis.numero_devis);
            $("#ttcDevis").text(devis.ttc_devis);
            $("#acompte").text(devis.acompte_devis);
        });

        // Redirection du bouton "Edition facture"
        $("#facture").click(function(){
            var url = "editionFacture.php?id_rdv=" + id_rdv;
            window.location.href = url;
        })
    });

    // Evenement du bouton suite: reglement
    $("#boutonReglement").click(function(){
      // On récupère le numéro du rdv passé dans l'url
      var id_rdv = getParameterByName("id_rdv");
      // Appel Ajax, on veut vérifier qu'une facture existe, on passe dans la requete la seule donnée que nous avons, l'id du rdv
      $.get("ajaxFacture.php?id_rdv=" + (id_rdv), function(data){
            //  On récupère les données JSON de PHP
            var facture = $.parseJSON(data);        
            if (facture.resultat == "Facture presente"){
                var url = "compteRenduIntervention2.php?id_facture=" + facture.id_facture;
                window.location.href = url;
            } else if (facture.resultat == "Pas de facture"){
                $("#boutonReglement").remove();
                $("#reglement").append("<p class='text-danger'><b>Il n'y a pas de facture pour ce devis, vous devez d'abord valider le volume et éditer une facture.</b></p>")
            }
      });
    })

});