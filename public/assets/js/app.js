import {Carrousel} from './carrousel.js';
import { Fetch } from './fetch.js';

// Le fichier app.js gère l'application
// Le module app est le module de l'application (des parties JS du site web)
const App = {

    // Méthode d'initialisation de l'application
    init: function() {

        // = On va initialiser tous les modules qui doivent être lancés au chargement de la page
    
        if (document.title === "TheCookBook") {
            // = modules lancés sur la page home
            Carrousel.init();
            Fetch.init();
        }

    }

};



// On exécute app.init quand la page est chargée
document.addEventListener('DOMContentLoaded', App.init);
