const mix = require('laravel-mix');
const path = require('path');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix
    .alias({
        '@': path.join(__dirname, 'resources/vue'),
    })
    .ts('resources/vue/bootstrap.ts', 'public/js/app.min.js')
    .copyDirectory('resources/assets/images/', 'public/img/')
    .copyDirectory('resources/locales', 'public/locales')
    .vue()
    .postCss('resources/assets/tailwind.css', 'public/css', [
        require('tailwindcss'),
    ])
    .extract(['vue'])
    .browserSync('localhost:80');
