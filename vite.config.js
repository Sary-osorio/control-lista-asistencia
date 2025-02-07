import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    build: {
        outDir: 'public/build',     // Carpeta donde se generarán los archivos compilados
        manifest: true,             // Genera un manifiesto para que Laravel lo pueda usar
        chunkSizeWarningLimit: 500  // Aumenta el límite de tamaño de chunks si es necesario
    },
});
