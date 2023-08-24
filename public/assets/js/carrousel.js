export const carrousel = {
    cardsContainer: document.querySelectorAll(".cards"),

    // Méthode d'initialisation de l'application
    init: function() {

        console.log('carrousel module initalisation => ok');

        console.log(carrousel.cardsContainer);

        for (const cards of carrousel.cardsContainer) {
            carrousel.initiateCardsContainerSize(cards);
        }

    },

    initiateCardsContainerSize: function(cards) {

        
        const cards_container = cards.querySelectorAll(".cards_container");
        const size = cards_container.length;
        console.log("nombre de recette dans la card : " + size);

        cards.querySelector(".cards_carrousel").style.width = `calc(100% *  ${size})`; 
    }
}