import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
const path = require('path');

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/back/css/app.css',
                'resources/back/js/app.js',
            ],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    // The Vue plugin will re-write asset URLs, when referenced
                    // in Single File Components, to point to the Laravel web
                    // server. Setting this to `null` allows the Laravel plugin
                    // to instead re-write asset URLs to point to the Vite
                    // server instead.
                    base: null,

                    // The Vue plugin will parse absolute URLs and treat them
                    // as absolute paths to files on disk. Setting this to
                    // `false` will leave absolute URLs un-touched so they can
                    // reference assets in the public directly as expected.
                    includeAbsolute: false,
                },
            },
        }),    ],
    resolve: {
        alias: {
            '@': '/resources/ts',
            'vue': 'vue/dist/vue.esm-bundler.js',
            '@base': path.resolve(__dirname, 'vendor/sdkconsultoria/base/resources'),
            '@node': path.resolve(__dirname, 'node_modules')
        },
    },
    server: {
        port: 5173,
        host: '127.0.0.1',
      },
});
