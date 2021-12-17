// Script pour valider les données rentrées dans le formulaire de création du compte creerCompteTechnicien.html
// Pour être certain que le DOM est chargé
$(document).ready(function () {
    // Evenement du bouton submit du formulaire
  $("#formulaireCreation").submit(function (event) {
    var password =
      /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&_~'#^ç=,;:/-])[A-Za-z\d@$!%*?&_~'#^ç=,;:/-].{7,51}$/; // définition du RegExp : Le mot de passe doit contenir au minimum une minuscule, une majuscule, un chiffre, un caractère spécial et comprenant minimum 8 et maximum 50 caractères
    var motdepasseTechnicien = $("#motDePasse_technicien").val();
    $("#erreur").remove(); // Pour éviter que le message d'erreur s'affiche plusieurs fois
    // On vérifie que le prénom est compris entre 3 et 50 caractères
    if (
      ($("#prenom_technicien").val().length < 3) |
      ($("#prenom_technicien").val().length > 50)
    ) {
      $("#prenom_technicien").after(
        "<span id='erreur' class='text-danger'><b>Ce champ doit contenir entre 3 et 50 caractères</b></span>"
      );
      event.preventDefault(); // Le navigateur ne peut pas envoyer le formulaire
      // On vérifie que le nom est compris entre 3 et 50 caractères
    } else if (
      ($("#nom_technicien").val().length < 3) |
      ($("#nom_technicien").val().length > 50)
    ) {
      $("#nom_technicien").after(
        "<span id='erreur' class='text-danger'><b>Ce champ doit contenir entre 3 et 50 caractères</b></span>"
      );
      event.preventDefault();
      // On vérifie que le mot de passe et la confirmation sont identiques
    } else if (
      $("#motDePasse_technicien").val() !=
      $("#confirmerMotDePasse_technicien").val()
    ) {
      $("#confirmerMotDePasse_technicien").after(
        "<span id='erreur' class='text-danger'><b>Les mots de passe sont différents</b></span>"
      );
      event.preventDefault();
      // On vérifie que le mot de passe correspond au format du RegExp
    } else if (password.test(motdepasseTechnicien)) {
      event.preventDefault();
      var donnees = $(this).serialize(); // On créer une variable sur les éléments du formulaire en sérialisant les valeurs
      // Appel Ajax
      $.post(
        "ajaxCreerCompteTechnicien.php", // Renvoi vers le script php
        donnees, // Envoi des données
        function (data) {
          // Renvoi une erreur à l'utilisateur si la validation côté serveur est mauvaise
          if (data == "Erreur1") {
            $("#resultat").html(
              "<p class='text-danger'><b>Ce compte utilisateur existe déjà !</b></p>"
            );
          } else if (data == "Erreur2") {
            $("#resultat").html(
              "<p class='text-danger'><b>Vos identifiants ou mot de passe ne respectent pas le format.</b></p>"
            );
          } else if (data == "Erreur3") {
            $("#resultat").html(
              "<p class='text-danger'><b>Les deux mots de passe ne correspondent pas...</b></p>"
            );
          } else {
            $("#resultat").html(
              "<p class='text-primary'><b>Votre compte a été créé</b>"
            );
            $("#bouton").remove();
            // Création du nouveau bouton de connexion
            $("#boutonSeConnecter").append(
              '<a class="btn" href="accueilTechnicien.php">Se connecter</a>'
            );
          }
        },
        "text" // Nous souhaitons recevoir du texte de la part du serveur pour gérer nos erreurs
      );
    } else {
      $("#motDePasse_technicien").after(
        "<span class='text-danger'><b>Le mot de passe doit contenir au minimum une minuscule, une majuscule, un chiffre, un caractère spécial et être compris entre 8 et 50 caractères</b></span>"
      );
      event.preventDefault();
    }
  });
});
