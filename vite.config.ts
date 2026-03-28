import { wayfinder } from '@laravel/vite-plugin-wayfinder';
import tailwindcss from '@tailwindcss/vite';
import react from '@vitejs/plugin-react';
import laravel from 'laravel-vite-plugin';
import { defineConfig } from 'vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.tsx'],
            ssr: 'resources/js/ssr.tsx',
            refresh: true,
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
});
