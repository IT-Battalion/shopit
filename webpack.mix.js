const mix = require('laravel-mix');
const path = require('path');
require('laravel-mix-bundle-analyzer');

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
    .vue({version: 3})
    .extract()
    .postCss('resources/assets/tailwind.css', 'public/css/vendor.css', [
        require('tailwindcss'),
    ])
    .css('node_modules/vue-skeletor/dist/vue-skeletor.css', 'public/css/vendor.css')
    .sass('resources/scss/vue-good-tables.sass', 'public/css/vendor.css')
    .sass('resources/scss/app.scss', 'public/css/vendor.css')
    //.sass('resources/assets/scss/shopit.scss', 'public/css/shopit.css')
    .sourceMaps()
    //.browserSync('localhost:80');

if (!mix.inProduction()) {
    mix.bundleAnalyzer();
}
