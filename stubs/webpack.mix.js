const mix = require('laravel-mix');
const path = require('path');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.webpackConfig({
    resolve: {
        alias: {
            '@base': path.resolve(__dirname, 'vendor/sdkconsultoria/base/resources'),
            '@node': path.resolve(__dirname, 'node_modules')
        }
    }
});

mix.js('resources/front/js/app.js', 'public/front.js');
mix.postCss("resources/front/css/app.css", "public/front.css", [
     require("tailwindcss"),
    ]);
mix.js('resources/back/js/app.js', 'public/back.js');
mix.postCss("resources/back/css/app.css", "public/back.css", [
     require("tailwindcss"),
    ]);
