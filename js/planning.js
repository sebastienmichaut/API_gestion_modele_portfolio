function getSemaineIndex() {
    var semaine = document.getElementsByClassName('semaine');
    for (let i = 0; i < 8; i++) {
        if (getComputedStyle(semaine[i]).display == "flex") {                   //Boucle pour savoir l'index de la semaine actuellement affichée
            index = i;
        }
    }
    return index;
}

function getJourIndex() {
    var jour = document.getElementsByClassName('jour');
    indexW = getSemaineIndex();
    for (let i = indexW*7; i < 56 - (56-(indexW + 1) * 7); i++) {
        if (getComputedStyle(jour[i]).display == "flex") {                      //Boucle pour savoir l'index du jour actuellement affiché
            indexD = i;
        }
    }
    return indexD;
}

function previous() {                                                           //Fonction du bouton précédent du planning des rendez-vous
    var semaine = document.getElementsByClassName('semaine');
    index = getSemaineIndex();
    currentDiv = semaine[index]; 
    jour = document.getElementsByClassName('jour');
    indexD = getJourIndex();
    document.getElementById('nextWbutton').removeAttribute('disabled');         //Bouton "suivant" rendu disponible 
    var prevIndex = index - 1;
    if (currentDiv != semaine[0]) {                                             //Affichage de la semaine précédente si ce n'est pas la première
        var prevDiv = semaine[prevIndex];
        currentDiv.style.display = 'none';
        prevDiv.style.display = 'flex';
        if (window.innerWidth < 1025) {                                         //Affichage du jour de la semaine précédente si la page affiche jour par jour
            jour[indexD].style.display = "none";
            jour[indexD - 7].style.display = "flex";
        }
        if (prevIndex < 1) {
            document.getElementById('prevWbutton').setAttribute('disabled','')  //Bouton "précédent" rendu indisponible si c'est la 1re semaine affichée
        }
    }
}

function next() {                                                               //Fonction du bouton suivant du planning des rendez-vous
    var semaine = document.getElementsByClassName('semaine');
    index = getSemaineIndex();
    currentDiv = semaine[index];
    jour = document.getElementsByClassName('jour');
    indexD = getJourIndex();
    document.getElementById('prevWbutton').removeAttribute('disabled');         //Bouton "suivant" rendu disponible 
    if (currentDiv != semaine[7]) {                                             //Affichage de la semaine suivante si ce n'est pas la dernière
        var nextDiv = semaine[index + 1];
        currentDiv.style.display = 'none';
        nextDiv.style.display = 'flex';
        if (window.innerWidth < 1025) {                                         //Affichage du jour de la semaine suivante si la page affiche jour par jour
            jour[indexD].style.display = "none";
            jour[indexD + 7].style.display = "flex";
        }
        if (nextDiv == semaine[7]) {
            document.getElementById('nextWbutton').setAttribute('disabled',''); //Bouton "suivant" rendu indisponible si c'est la dernière semaine affichée
        }
    } 
}

function previousDay() {                                                        //Fonction pour aller au prochain jour lorsque l'écran n'est pas assez large
    var jour = document.getElementsByClassName('jour');                         //Tableau des div jour        
    var semaine = document.getElementsByClassName('semaine');                   //Tableau des div semaine
    indexD = getJourIndex();                                                    //indice du jour affiché dans le tableau
    indexW = getSemaineIndex();                                                 //indice de la semaine affichée dans le tableau
    var currentDay = jour[indexD];                                              //Jour affiché
    document.getElementById('nextDbutton').removeAttribute('disabled');         //Bouton 'jour précédent' rendu disponible
    if (indexD > 0) {                                                           //script réalisé si ce n'est pas le dernier jour affiché
        var prevDay = jour[indexD - 1];                                         //Variable contenant le jour suivant (le jour à afficher)
        if (indexD % 7 == 0) {                                                  //Si c'est la fin de semaine, passage à la semaine suivante donc la div semaine suivante
            currentDay.style.display = "none";
            semaine[indexW].style.display = "none";
            semaine[indexW - 1].style.display = "flex";
        }
        currentDay.style.display = 'none';
        prevDay.style.display = 'flex';
        if (indexD - 1 < 1) {
            document.getElementById('prevDbutton').setAttribute('disabled','')  //Bouton "précédent" rendu indisponible si c'est la 1re semaine affichée
        }
    }
}

function nextDay() {                                                            //Fonction pour aller au prochain jour lorsque l'écran n'est pas assez large
    var jour = document.getElementsByClassName('jour');                         //Tableau des div jour
    var semaine = document.getElementsByClassName('semaine');                   //Tableau des div semaine
    indexD = getJourIndex();                                                    //indice du jour affiché dans le tableau
    indexW = getSemaineIndex();                                                 //indice de la semaine affichée dans le tableau
    var currentDay = jour[indexD];                                              //Jour affiché
    document.getElementById('prevDbutton').removeAttribute('disabled');         //Bouton 'jour précédent' rendu disponible
    if (indexD < 55) {                                                          //script réalisé si ce n'est pas le dernier jour affiché
        var nextDay = jour[indexD + 1];                                         //Variable contenant le jour suivant (le jour à afficher)
        if (indexD % 7 == 6) {                                                  //Si c'est la fin de semaine, passage à la semaine suivante donc la div semaine suivante
            currentDay.style.display = 'none';
            semaine[indexW].style.display = "none";
            semaine[indexW + 1].style.display = "flex";
            nextDay.style.display = "flex";
        } else {
            currentDay.style.display = 'none';
            nextDay.style.display = 'flex';
        }
        if (indexD + 1 == 55) {
            document.getElementById('nextDbutton').setAttribute('disabled','')  //Bouton "suivant" rendu indisponible si c'est le dernier jour affiché
        }
    }
}

function resize() {                                                             //Fonction affichant la semaine entière ou seulement jour par jour en fonction de la taille de la fenêtre
    let jour = document.getElementsByClassName('jour');                         //indice du jour affiché dans le tableau des div jour
    let indexW = getSemaineIndex();                                             //Indice de la semaine
    let indexD = indexW * 7;                                                    //Détermination du lundi de la semaine affichée 
    for (let index = 0; index < jour.length; index++) {
        if (window.innerWidth > 1025) {                                         //Tous les jours de la semaine sont affichés si la fenetre est assez large
            jour[index].style.display = "flex";
        } else {
            jour[indexD].style.display = "flex";                                //Seulement le lundi est affiché si la fenêtre n'est pas asez large
            jour[index].style.display = "none";
        }
        
    }
}