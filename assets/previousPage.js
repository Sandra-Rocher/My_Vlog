//SRO For back to the previous page on showId button.


// alert("Script chargé ! ");
// document.addEventListener("DOMContentLoaded", function() {
//     const returnButton = document.getElementById('return-last-page');
//     if (returnButton) {
//         alert("Bouton trouvé !");
//         returnButton.addEventListener('click', function(event) {
//             event.preventDefault();
//             const referer = document.referrer;
//             alert('Referer: ' + referer + ', Referer2: ' + HTTP_REFERER);
//             if (referer && referer !== "") {
//                 window.location.href = referer;
//             } else {
//                 window.location.href = "{{ path('location.index') }}";
//             }
//         });
//     } else {
//         alert("Bouton non trouvé");
//     }
// });


// document.addEventListener("DOMContentLoaded", function() {
//     const returnButton = document.getElementById('return-last-page');
    
//     // Si le bouton retour existe sur la page
//     if (returnButton) {
//         // Ajoute un événement click pour le bouton retour
//         returnButton.addEventListener('click', function(event) {
//             event.preventDefault();  // Empêche l'action par défaut du bouton (le lien)

//            // Récupère le referer de l'URL (si passé en tant que paramètre)
//            const urlParams = new URLSearchParams(window.location.search);
//            const referer = urlParams.get('referer') || document.referrer;  // Utilise le referer dans l'URL ou le document.referrer
            
//             if (referer && referer !== "") {
//                 // Si un referer est trouvé, on redirige l'utilisateur vers cette page
//                 window.location.href = referer;
//             } else {
//                 // Si aucun referer, rediriger vers la page d'accueil
//                 window.location.href = "{{ path('location.index') }}";  // Utilise la route Symfony
//             }
//         });
//     }
// });


// document.addEventListener("DOMContentLoaded", function() {
//     const returnButton = document.getElementById('return-last-page');

//     // Si le bouton retour existe sur la page
//     if (returnButton) {
//         // Ajoute un événement click pour le bouton retour
//         returnButton.addEventListener('click', function(event) {
//             event.preventDefault();  // Empêche l'action par défaut du bouton (le lien)

//             // Récupère le referer de l'URL (si passé en tant que paramètre)
//             const urlParams = new URLSearchParams(window.location.search);
//             const referer = urlParams.get('referer') || document.referrer;  // Utilise le referer dans l'URL ou le document.referrer

//             // Affiche la valeur du referer dans un message
//             alert("Referer: " + referer ,"Referer2: " + document.referrer ,"Referer3: " + urlParams);
//         });
//     }
// });


// document.addEventListener("DOMContentLoaded", function() {
//     const returnButton = document.getElementById('return-last-page');
    
//     if (returnButton) {
//         returnButton.addEventListener('click', function(event) {
//             event.preventDefault(); // Empêche l'action par défaut du bouton (le lien)
            
//             // Récupère le referer via document.referrer
//             const referer = document.referrer;
            
//             // Crée un élément pour afficher le referer sur la page
//             const refererElement = document.createElement('div');
//             refererElement.id = 'referer-debug';
//             refererElement.style.position = 'absolute';
//             refererElement.style.top = '20px';
//             refererElement.style.left = '20px';
//             refererElement.style.backgroundColor = 'yellow';
//             refererElement.style.padding = '10px';
//             refererElement.innerText = "HTTP Referer: " + referer;
            
//             // Ajoute cet élément au body de la page pour afficher le referer
//             document.body.appendChild(refererElement);
            
//             // Optionnel : Rediriger vers le referer si nécessaire
//             if (referer) {
//                 window.location.href = referer;
//             } else {
//                 // Si aucun referer, redirige vers la page d'accueil
//                 window.location.href = "/home"; // Remplace par la route que tu veux
//             }
//         });
//     }
// });
