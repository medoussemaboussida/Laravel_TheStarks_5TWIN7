// resources/js/app.js
import './bootstrap'; // déjà présent (laravel setup)

import $ from 'jquery';
window.$ = window.jQuery = $;

// Si tu as installé bootstrap via npm :
import 'bootstrap';

// Si tu as copié les fichiers du template en resources/js :
import './sb-admin-2.min.js';

// ou si le template a des plugins séparés, importe-les ici, ex:
// import './plugins/chartjs.min.js';

console.log('App JS chargé');
