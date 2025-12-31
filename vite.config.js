import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/shared.css',
                'resources/css/admin.css',
                'resources/css/mahasiswa.css',
                'resources/css/auth.css',
                'resources/js/app.js',
                'resources/js/admin.js',
                'resources/js/mahasiswa.js',
                'resources/js/auth.js',
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
