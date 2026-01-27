import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/custom.js',
                'resources/js/charts.js',
                'resources/js/budget.js',
                'resources/js/dashboard.js',
                'resources/js/modal-handler.js',
            ],
                
            refresh: true,
        }),
    ],
});
