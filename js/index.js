
// Script pour la connexion au compte du technicien index.hml
// Pour être certain que le DOM est chargé
$(document).ready(function () {
    // Evenement du bouton submit du formulaire
  $("#formulaireConnexion").submit(function (event) {
    event.preventDefault();
    $("#erreur").remove(); // Pour éviter que le message d'erreur s'affiche plusieurs fois
    // On vérifie que le prénom est compris entre 3 et 50 caractères
    if (
      ($("#prenom_technicien").val().length < 3) ||
      ($("#prenom_technicien").val().length > 50)
    ) {
      $("#prenom_technicien").after(
        "<span id='erreur' class='text-danger'><b>Ce champ doit contenir entre 3 et 50 caractères</b></span>"
      );
      event.preventDefault();
      // On vérifie que le nom est compris entre 3 et 50 caractères
    } else if (
      ($("#nom_technicien").val().length < 3) ||
      ($("#nom_technicien").val().length > 50)
    ) {
      $("#nom_technicien").after(
        "<span id='erreur' class='text-danger'><b>Ce champ doit contenir entre 3 et 50 caractères</b></span>"
      );
      event.preventDefault();
    } else {
      var donnees = $(this).serialize(); // On crée une variable sur les éléments du formulaire en sérialisant les valeurs
      // Appel Ajax
      $.post(
        "ajaxIndex.php", // Renvoi vers le script php
        donnees, // Envoi des données
        function (data) {
          // Renvoi une erreur à l'utilisateur si la validation côté serveur est mauvaise
          if (data == "Erreur1") {
            $("#resultat").html(
              "<p class='text-danger'><b>Vos identifiants ou mot de passe sont incorrects</b></p>"
            );
          } else if (data == "Erreur2") {
            $("#resultat").html(
              "<p class='text-danger'><b>Vos identifiants ne respectent pas le format</b></p>"
            );
          } else if (data == "ok") {
            window.location.href = "accueilTechnicien.php";
          }
        },
        "text" // Nous souhaitons recevoir du texte de la part du serveur pour gérer nos erreurs
      );
    }
  });
});
