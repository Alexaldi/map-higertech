import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';
import { networkInterfaces } from 'node:os';

function getLocalIp() {
    const nets = networkInterfaces();
    for (const name of Object.keys(nets)) {
        for (const net of nets[name] || []) {
            if (net.family === 'IPv4' && !net.internal && !name.includes('VMware') && !name.includes('Virtual')) {
                return net.address;
            }
        }
    }
    return 'localhost';
}

const localIp = getLocalIp();

export default defineConfig({
    build: {
        sourcemap: false,
    },
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        host: '0.0.0.0',
        cors: true,
        origin: `http://${localIp}:5173`,
        hmr: {
            host: localIp,
        },
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
