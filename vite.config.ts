import { wayfinder } from '@laravel/vite-plugin-wayfinder';
import tailwindcss from '@tailwindcss/vite';
import react from '@vitejs/plugin-react';
import laravel from 'laravel-vite-plugin';
import { defineConfig } from 'vite';
import path from 'path';
import { fileURLToPath } from 'url';

const __dirname = path.dirname(fileURLToPath(import.meta.url));

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.tsx'],
            ssr: 'resources/js/ssr.tsx',
            refresh: true
        }),
        react({
            babel: {
                plugins: ['babel-plugin-react-compiler'],
            },
        }),
        tailwindcss(),
        //wayfinder({
        //    formVariants: true,
        //}),
    ],
    server: {
        host: '0.0.0.0',  // Разрешаем доступ извне контейнера
        port: 5173,
        strictPort: true,
        hmr: {
            host: 'localhost',  // Для hot-reload
            port: 5173,
            protocol: 'ws',
        },
        watch: {
            usePolling: true,  // Важно для Docker
            interval: 1000,     // Интервал опроса файлов
        },
    },
    esbuild: {
        jsx: 'automatic',
    },
    resolve: {
        alias: {
            '@common': path.resolve(__dirname, 'resources/js/common'),
            '@manager': path.resolve(__dirname, 'resources/js/manager'),
            '@managerRoutes': path.resolve(__dirname, 'resources/js/common/wayfinder/routes/manager'),
            '@client': path.resolve(__dirname, 'resources/js/client'),
            '@clientRoutes': path.resolve(__dirname, 'resources/js/common/wayfinder/routes/client'),
            '@notary': path.resolve(__dirname, 'resources/js/notary'),
            '@notaryRoutes': path.resolve(__dirname, 'resources/js/common/wayfinder/routes/notary'),
        },
    },
});
