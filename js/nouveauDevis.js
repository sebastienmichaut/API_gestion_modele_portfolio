// Script pour modifier le volume dans la partie nouveauDevis.php

$(document).ready(function () {
  
  var surface = $("#surface_devis");
  var hauteur = $("#hauteur_devis");
  var volume = $("#volume_devis");
  var volume2 = $("#volume_devis2");

  function calcul(){
    resultat = surface.val() * hauteur.val();
    volume.val(resultat);
    volume2.val(resultat);
    console.log(volume2);
    console.log(volume);
    console.log(resultat);
  }

  surface.keyup(calcul);
  hauteur.keyup(calcul);
});
