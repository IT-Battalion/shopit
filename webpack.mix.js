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
    .postCss('resources/css/app.css', 'public/css', [
        require('tailwindcss'),
    ])
    .alias({
        '@': path.join(__dirname, 'resources/ts'),
    })
    .ts('resources/ts/app.ts', 'public/js')
    .vue()
    .extract(['vue'])
    .sass('resources/sass/app.scss', 'public/css')
    .browserSync('laravel.test');
