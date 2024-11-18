//SRO for infinite carousel

document.addEventListener("DOMContentLoaded", function () {
    const logoItems = document.querySelector(".logo_items");

    if (logoItems) {
        const clone = logoItems.innerHTML;

        // Ajouter 5 clones supplémentaires
        for (let i = 0; i < 5; i++) {
            logoItems.innerHTML += clone;
        }
    }
});
