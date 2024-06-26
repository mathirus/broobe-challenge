import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/custom-datatables.css',
                'resources/js/app.js',
                'resources/js/datatables-init.js',
                'resources/js/scripts.js'
            ],
            refresh: true,
        }),
    ],
});
