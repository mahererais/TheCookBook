export const Fetch = {


    init: function () {
        Fetch.fetchRecipe();
        
        setInterval(() => { 
            Fetch.fetchRecipe();
        }, 5000);
    },

    fetchRecipe: function () {
        const url = window.location.href + "api/recipe/random";
        fetch(url)
            .then(response => response.json())
            .then(data => {
                Fetch.updateRandomRecipeWithData(data);
            })
    },

    /**
     * update on home page, random recipe div.r_cards_container
     * @param {String[]} data 
     */
    updateRandomRecipeWithData: function (data) {
        document.querySelector(".r_cards_container img").dataset.src = data.picture;
        document.querySelector(".r_cards_container div h2").textContent = data.title;
        document.querySelector(".r_cards_container div h3").textContent = "categorie: " + data.category;
        document.querySelector(".r_cards_container div a").textContent =  `${data.firstname} ${data.lastname}`;
        document.querySelector(".r_cards_container div a").href = `\\user\\${data.lastname}`;
    }

}
