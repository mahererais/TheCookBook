export const Carrousel = {
    cardsContainer: document.querySelectorAll(".cards"),

    // Méthode d'initialisation de l'application
    init: function () {

        for (const cards of Carrousel.cardsContainer) {
            new Cards(cards);
        }


    },


}


/**
 * Cards class handle carrousel of a liste recipe  
 */
class Cards {
    /** @property cardWidth: recipe card width size (pixel) */
    cardWidth = 0;
    /** @property leftButton: left button of carrousel (Element) */
    leftButton = null;
    /** @property rightButton: right button of carrousel (Element) */
    rightButton = null;
    /** @property cardsList: list of recipes */
    cardsList = null;
    /** @property numberOfCard: number of recipes */
    numberOfCard = 0;
    /** @property currentSelectedCardIndex: current index recipe display on screen */
    currentSelectedCardIndex = 0;

    constructor(card) {
        // initialisation of class @properties 
        this.cardWidth = card.querySelector(".cards_carrousel_container").clientWidth;
        this.leftButton = card.querySelector(".tcb_btn_caroussel_left");
        this.rightButton = card.querySelector(".tcb_btn_caroussel_right");
        this.cardsList = card.querySelectorAll('.cards_container');
        this.numberOfCard = this.cardsList.length;

        this.leftButton.addEventListener('click', this.leftButtonHandler.bind(this));
        this.rightButton.addEventListener('click', this.rightButtonHandler.bind(this));

        this.buttonsRendering();

        // we need to observe recipe card width when user resize his screen
        this.observeCarrouselContainerResize(card.querySelector(".cards_carrousel_container"));
    }

    // ! source:  https://www.youtube.com/watch?v=M2c37drnnOA
    observeCarrouselContainerResize(elementToObseve) {
        const observer = new ResizeObserver(entries => {
            console.log("coucou");
            const element = entries[0];
            this.cardWidth = element.contentRect.width;
            this.showCurrentRecipe();
        })

        observer.observe(elementToObseve);
    }


    /**
     * called when user click on left button
     * @param {Event} e 
     */
    leftButtonHandler(e) {
        this.currentSelectedCardIndex--;

        // check if current recipe displayed on screen is first, 
        // then we display last recipe from list  
        if (this.currentSelectedCardIndex < 0){
            this.currentSelectedCardIndex = this.numberOfCard - 1;
        }

        this.showCurrentRecipe();
        this.buttonsRendering();
    }

    /**
     * called when user click on right button
     * @param {Event} e 
     */
    rightButtonHandler(e) {
        this.currentSelectedCardIndex++;

        if (this.currentSelectedCardIndex >= this.numberOfCard)
            this.currentSelectedCardIndex = 0;

        this.showCurrentRecipe();
        this.buttonsRendering();
    }

    /**
     * display on screen current recipe choose
     */
    showCurrentRecipe() {
        this.cardsList[this.currentSelectedCardIndex].parentElement.style.transform = `translateX(-${this.currentSelectedCardIndex * this.cardWidth}px)`;
    }

    /**
     * render button left if recipe on screen is not first recipe on list
     * render button right if recipe on screen is not last recipe on list
     */
    buttonsRendering() {
        this.leftButton.style.display = "";
        this.rightButton.style.display = "";
        if (this.currentSelectedCardIndex === 0) {
            // current recipe on screen is first on list => hide left button, 
            this.leftButton.style.display = "none";
        }else if(this.currentSelectedCardIndex === (this.numberOfCard - 1)) {
            // current recipe on screen is last on list => hide right button, 
            this.rightButton.style.display = "none";
        }
    }

}