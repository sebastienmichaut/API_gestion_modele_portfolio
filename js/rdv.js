// Script pour générer des rendez-vous depuis accueilTechnicien.php vers generationRdv.php
// Pour être certain que le DOM est chargé
$(document).ready(function () {
    // Evenement du bouton submit du formulaire
  $("#genererRdv").click(function () {
    var clickBtnValue = $(this).val();
    data =  {'action': clickBtnValue};
    $.post(
      "generationRdv.php",
      data,
      function (response){
        $("#genererRdv").after(response);
        /*if (response == "ok") {
          $("#genererRdv").html("<span>Bravo, vos rendez-vous sont dans le planning. Au travail !</span>");
        } else if (response == "erreur"){
          $("#genererRdv").html("<span class='text-danger'><b>Une erreur est survenue</b></span>");
        }*/
      },
      "text"
    );
  })
})
