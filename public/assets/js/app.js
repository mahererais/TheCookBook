import {carrousel} from './carrousel.js';

// Le fichier app.js gère l'application
// Le module app est le module de l'application (des parties JS du site web)
const app = {

    // Méthode d'initialisation de l'application
    init: function() {

        console.log('App module initalisation => ok');

        //return ;
        // On va initialiser tous les modules qui doivent être lancés au chargement de la page
        carrousel.init();

    }

};

// On exécute app.init quand la page est chargée
document.addEventListener('DOMContentLoaded', app.init);