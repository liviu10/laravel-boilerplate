import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/admin.scss',
                'resources/sass/auth.scss',
                'resources/sass/guest.scss',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
});
