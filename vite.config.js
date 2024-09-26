import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

import os from 'node:os';

const hostname = os.hostname();

export default defineConfig({
    server: {
        origin: `http://${hostname}:5173`,
        host: true,
    },
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
});
