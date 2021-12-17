// Pour être certain que le DOM est chargé
$(document).ready(function () {

    function getParameterByName(name, url = window.location.href) {
        name = name.replace(/[\[\]]/g, "\\$&");
        var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
        if (!results) return null;
        if (!results[2]) return "";
        return decodeURIComponent(results[2].replace(/\+/g, " "));
    };

    // Si les champs 'Reglement par CB' sont rempli alors les champs 'Reglement par cheque' sont désactivés et inversement
    $('input').each(function(){
        if($(".CB").on()){
            $(".CB").keyup(function(){
                $(".cheque").each(function(){
                    $(this).prop("disabled", true);
                })
            });
        }if($(".cheque").on()){
            $(".cheque").keyup(function(){
                $(".CB").each(function () {
                    $(this).prop("disabled", true);
                })
            });
        }
    })
        
    // Evènement sur la soumission du formulaire
    $("#facture").submit(function(event){
        event.preventDefault();
        // On récupère le numéro de la facture passé dans l'url
        var id_facture = getParameterByName('id_facture');
        // Appel Ajax, on passe dans la requete, le numero de la facture
        if (($.isNumeric($("#num_transaction_facture").val())) && ($.isNumeric($("#montant_CB_facture").val())) || (($.isNumeric($("#montant_cheque_facture").val())) && ($.isNumeric($("#num_cheque_facture").val())) && ($.isNumeric($("#num_ci_facture").val())))) {
            console.log("ok1");
            var donnees = $(this).serialize(); // On créer une variable sur les éléments du formulaire en sérialisant les valeurs
            console.log(donnees);
            // Appel Ajax
            $.post(
              "ajaxReglement.php?id_facture=" + id_facture, // Renvoi vers le script php
              donnees, // Envoi des donnees
                function (data) {
                    if (data == "Erreur"){
                        alert("Une erreur est survenue, un champ est peut-être mal renseigné");
                    }else if (data == "Cheque") {
                        $("#btnEnregistrer").replaceWith("<h4 class='text-primary'><b>Le chèque à été enregistré avec succès !</b></h3>");
                    } else if (data == "CB") {
                        $("#btnEnregistrer").replaceWith("<h4 class='text-primary'><b>La CB à été enregistré avec succès !</b></h3>");
                    };
                },
                "text" // Nous souhaitons recevoir du texte de la part du serveur pour gérer nos erreurs
            );
        }else {
            alert("Le montant doit être un nombre et/ou le numéro de transaction, le numéro du chèque , n° carte d'identité aussi");
            event.preventDefault();
        };
    })
})