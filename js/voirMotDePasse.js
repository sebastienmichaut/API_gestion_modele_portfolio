// Script pour afficher ou cacher le mot de passe dans index.html et creerCompteTechnicien.html
viewpass.addEventListener("click", function () {
  var viewpass = document.getElementById("viewpass");
  var mdp = document.querySelectorAll(".mdp");

  for (var i = 0; i < mdp.length; i++) {
    /* Boucle qui permet d'afficher/cacher le mot de passe ET la confirmation lors de la création du compte dans creerCompteTechnicien.html */
    if (mdp[i].type == "password") {
      /* Afficher le mot de passe */
      mdp[i].type = "text";
      viewpass.textContent = "Cacher le mot de passe ";
      var icone = document.createElement("i");
      // Permet d'insérer l'icone "oeil" de Font Awesome
      icone.className = "fas fa-eye-slash";
      viewpass.appendChild(icone);
    } else {
      /* Cacher le mot de passe */
      mdp[i].type = "password";
      viewpass.textContent = "Afficher le mot de passe ";
      var icone = document.createElement("i");
      icone.className = "fas fa-eye";
      viewpass.appendChild(icone);
    }
  }
});
