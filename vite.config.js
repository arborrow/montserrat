import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/assets/sass/app.scss',
                'resources/assets/sass/pdf-certificate.scss',
                'resources/assets/sass/pdf-style.scss',
                'resources/assets/sass/print-envelope10.scss',
                'resources/assets/sass/print-envelope9x6.scss',
                'resources/assets/sass/print-landscape.scss',
                'resources/assets/sass/print-style.scss',
                'resources/assets/js/app.js',
            ],
            refresh: true,
        }),
    ],
});
