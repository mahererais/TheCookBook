import {Carrousel} from './carrousel.js';

// Le fichier app.js gère l'application
// Le module app est le module de l'application (des parties JS du site web)
const App = {

    // Méthode d'initialisation de l'application
    init: function() {

        // ('App module initalisation => ok');

        // On va initialiser tous les modules qui doivent être lancés au chargement de la page
        
        
        if (document.title === "Page d'accueil") {
            Carrousel.init();
        }

    }

};



// On exécute app.init quand la page est chargée
document.addEventListener('DOMContentLoaded', App.init);