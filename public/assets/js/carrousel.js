export const carrousel = {
    cardsContainer: document.querySelectorAll(".cards"),

    // Méthode d'initialisation de l'application
    init: function () {

        console.log('carrousel module initalisation => ok');

        console.log(carrousel.cardsContainer);

        for (const cards of carrousel.cardsContainer) {
            carrousel.initiateCardsCategory(cards);

        }


    },

    initiateCardsCategory: function (cards) {

        const leftButton = cards.querySelector(".tcb_btn_caroussel_left");
        const rightButton = cards.querySelector(".tcb_btn_caroussel_right");

        const subCardsList = cards.querySelectorAll('.cards_container');

        const nbrCards = subCardsList.length;
        let currentSelectedIndex = 0;

        subCardsList[currentSelectedIndex].classList.add("card_selected");


        leftButton.addEventListener("click", function (e) {
            subCardsList[currentSelectedIndex].classList.remove("card_selected");
            console.log("left button clicked from " + currentSelectedIndex + " to " + (currentSelectedIndex - 1));
            currentSelectedIndex--;
            if (currentSelectedIndex < 0) {
                currentSelectedIndex = nbrCards-1;
            }
            subCardsList[currentSelectedIndex].classList.add("card_selected");
        });

        rightButton.addEventListener("click", function (e) {
            subCardsList[currentSelectedIndex].classList.remove("card_selected");
            console.log("right button clicked from " + currentSelectedIndex + " to " + (currentSelectedIndex + 1));
            currentSelectedIndex++;
            if (currentSelectedIndex >= nbrCards) {
                currentSelectedIndex = 0;
            }
            subCardsList[currentSelectedIndex].classList.add("card_selected");
        });

    }
}