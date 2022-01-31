const mix = require('laravel-mix');
const mixPdf = require('laravel-mix');
const path = require('path');
const LodashModuleReplacementPlugin = require('lodash-webpack-plugin');
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
    .ts('resources/vue/bootstrap.ts', 'public/js/app.js')
    .babelConfig({
        plugins: [
            'babel-plugin-lodash',
        ],
    })
    .webpackConfig(webpack => {
        return {
            plugins: [
                new LodashModuleReplacementPlugin,
            ],
        }
    })
    .vue({version: 3})
    .extract([
        'vue-good-table-next', 'vue-skeletor', 'vue-toastification',
        'laravel-echo', 'pusher-js', 'axios',
        'laravel-mix',
        'mitt',
        'lodash',])
    .postCss('resources/assets/tailwind.css', 'public/css/vendor.css', [
        require('tailwindcss')('./tailwind.config.js'),
        require('autoprefixer'),
    ])
    .css('node_modules/vue-skeletor/dist/vue-skeletor.css', 'public/css/vendor.css')
    .sass('resources/scss/vue-good-tables.sass', 'public/css/vendor.css')
    .sass('resources/scss/app.scss', 'public/css/vendor.css')
    //.sass('resources/assets/scss/shopit.scss', 'public/css/shopit.css')
    .copyDirectory('resources/assets/images/', 'public/img/')
    .copyDirectory('resources/locales', 'public/locales')
    .sourceMaps()
    //.browserSync('localhost:80');

mixPdf
    .postCss('resources/assets/tailwind-pdf.css', 'public/css/vendor-pdf.css', [
        require('tailwindcss')('./tailwind-pdf.config.js'),
    ]);

if (!mix.inProduction()) {
    mix.bundleAnalyzer();
}
