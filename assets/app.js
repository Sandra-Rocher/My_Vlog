import './bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
// SRO styles css for base.html.twig
import './styles/app.css';
// SRO styles css for home/index.html.twig
import './styles/home.css';

// SRO Import script arrow.js for arrow up
import './arrow.js';

// SRO Import script infiniteCarousel.js for have an infinite carousel on home page
import './infiniteCarousel.js';

// SRO Import script meteo.js to obtain the weather forecast for the selected city on show page
import './meteo.js';


// TODO SRO import script of bootstrap for css, js and icons for remplace the 3 links in head and down body.
// import 'bootstrap/dist/css/bootstrap.min.css';
// import 'bootstrap/dist/js/bootstrap.bundle.min.js';
// import 'bootstrap-icons/font/bootstrap-icons.css';



console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');



// SRO TODO import links bootstrap, css and js and icons :
// import 'bootstrap/dist/css/bootstrap.min.css';
// import 'bootstrap/dist/js/bootstrap.bundle.min.js';
// import 'bootstrap-icons/font/bootstrap-icons.css';

