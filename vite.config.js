import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/sb-admin-2.min.css', // SB Admin 2 custom CSS
                'resources/vendor/fontawesome-free/css/all.min.css', // Font Awesome
                'resources/js/sb-admin-2.min.js', // SB Admin 2 custom JS
                'resources/vendor/jquery/jquery.min.js', // jQuery
                'resources/vendor/bootstrap/js/bootstrap.bundle.min.js', // Bootstrap JS
                'resources/vendor/jquery-easing/jquery.easing.min.js', // jQuery Easing
                'resources/vendor/chart.js/Chart.min.js', // Chart.js
                'resources/js/demo/chart-area-demo.js', // Chart demos
                'resources/js/demo/chart-pie-demo.js', // Chart demos
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        cors: true,
    },
});