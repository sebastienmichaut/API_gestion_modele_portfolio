// Script pour envoyer les données avec l'API fetch() sur le fichier ajaxModifInfoTech.php afin de mettre en bdd les informations du technicien
$(document).ready(function () { // On vérifie que le document est bien chargé
  $('#formulaireInfoTech').submit(function(event){  // Evenement sur le bouton du formulaire

    function validationEmail($email){
      var mail = /^[a-z0-9\-_]+[a-z0-9\.\-_]*@[a-z0-9\-_]{2,}\.[a-z\.\-_]+[a-z\-_]+$/i; //RegExp pour valider le format d'un mail
      return mail.test($email);
    }
    var mailTechnicien = $("#mail_technicien").val();

    event.preventDefault();
    $("#erreur").remove();  // Pour éviter que l'affichage des erreurs du serveur ne se répetent
    $(".voie").removeClass().addClass("voie form-control"); // Pour enlever l'avertissement d'une erreur quand un autre champ a aussi une erreur
    $(".cp").removeClass().addClass("cp form-control");
    $(".ville").removeClass().addClass("ville form-control");
    $("#tel_technicien").removeClass().addClass("form-control");
    $("#mail_technicien").removeClass().addClass("form-control");
    
    if ($(".voie").val().length < 5 || $(".voie").val().length > 50){ // Ligne 19 à 33, vérification des données rentrées dans le formulaire avec affichage d'un message d'erreur
        $(".voie").addClass("border border-danger  border border-2");
        $(".voie").after("<span id='erreur' class='text-danger'><b>Ce champ doit contenir entre 5 et 50 caractères</b></span>");
    } else if ($(".cp").val().length !== 5 && !$.isNumeric($(".cp").val())){
        $(".cp").addClass("border border-danger  border border-2");
        $(".cp").after("<span id='erreur' class='text-danger'><b>Ce champ doit contenir un code postal à 5 chiffres</b></span>");
    } else if ($('.ville').val().length < 2 || $('.ville').val().length > 50){
        $(".ville").addClass("border border-danger  border border-2");
        $(".ville").after("<span id='erreur' class='text-danger'><b>Ce champ doit contenir entre 2 et 50 caractères</b></span>");
    } else if ($("#tel_technicien").val().length !== 10 && !$.isNumeric($("#tel_technicien").val())){
        $("#tel_technicien").addClass("border border-danger  border border-2");
        $("#tel_technicien").after("<span id='erreur' class='text-danger'><b>Ce champ doit contenir 10 chiffres</b></span>");
    } else if ($("#mail_technicien").val().length == 0 || !(validationEmail(mailTechnicien))){
        $("#mail_technicien").addClass("border border-danger  border border-2");
        $("#mail_technicien").after("<span id='erreur' class='text-danger'><b>Entrez une adresse email valide</b></span>");    
    } else {
      const formData = new FormData(this); // Afin de rajouter une paire clé / valeur
      const searchParams = new URLSearchParams(); // Afin de générer des paramètres de requête
    
      for (const pair of formData){
        searchParams.append(pair[0], pair[1]);    
      }
      
      const url = "ajaxModifInfoTech.php";  // Fichier où sont envoyé les données
      const params = {
        method: "POST",
        mode: 'same-origin',
        body: searchParams,
      };
        
      fetch(url, params) // API fetch
        .then(async function(response){
          if(response.ok){
            await response.json().then(function(response){  // On récupère les réponses du serveur en format json
              JSON.stringify(response)
              if (response == "Infos ok") {
                  window.location.href = "informationsTechnicien.php";
              }else if (response == "erreur1"){ // On affiche les erreurs que pourrait renvoyer le serveur
                $("#ErreurServeur").html("<p class='text-danger text-center'><b>Le code postal et le téléphone doivent comporter respectivement 5 et 10 chiffres</b></p>");
              }else if (response == "erreur2"){
                $("#ErreurServeur").html("<p class='text-danger text-center'><b>Votre email a un format incorrect</b></p>");
              }else if (response == "erreur3"){
                $("#ErreurServeur").html("<p class='text-danger text-center'><b>Vous n'avez pas indiquer votre mail</b></p>");
              }else if (response == "erreur4"){
                window.location.href = "disconnect.php";
              }
            })
          } else {
            throw new Error(alert(response.status + ': ' + response.statusText)); // Permet d'afficher les erreurs comme par exemple 404
          }
        }).catch(e => console.error('Exception:', e))        
    }
  })
})


// $(document).ready(function () {
//   const formulaire = document.getElementById("formulaireInfoTech");
//   formulaire.addEventListener("submit", function (event) {
//     event.preventDefault();

//     const formData = new FormData(this);

//     fetch("test.php", {
//       method: "post",
//       body: formData,
//     })
//       .then(function (response) {
//         return response.text();
//       })
//       .then(function (text) {
//         console.log(text);
//       })
//       .catch(function (error) {
//         console.error(error);
//       });
//   });
// });