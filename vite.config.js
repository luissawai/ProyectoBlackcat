import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import { resolve } from 'path'; // Importa el módulo path

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/js/app.js', // Corregido para ser un array
                'resources/sass/app.scss', // Agrega tu archivo Sass aquí
            ],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    resolve: {
        alias: {
            '@': resolve(__dirname, 'resources/js'),
            '@images': resolve(__dirname, 'public/images'),
            '@videos': resolve(__dirname, 'public/videos'),

        },
    },
});