//SRO for infinite carousel

document.addEventListener("DOMContentLoaded", function () {
    const logoItems = document.querySelector(".logo_items");

    if (logoItems) {
        const clone = logoItems.innerHTML;
        logoItems.innerHTML += clone;
    }
});
