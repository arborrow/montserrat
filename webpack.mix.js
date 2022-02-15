const mix = require('laravel-mix');
const glob = require('@alexbinary/glob');
const CopyWebpackPlugin = require('copy-webpack-plugin');

// see https://github.com/arborrow/montserrat/issues/305
// for fontawesome to work when not in root directory
// mix.setPublicPath('public');
// mix.setResourceRoot('../../polanco');

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

mix.js('resources/assets/js/app.js', 'public/dist/bundle.js')
    .sass('resources/assets/sass/app.scss', 'public/dist/bundle.css').version()
    .sass('resources/assets/sass/print-envelope10.scss', 'public/dist/print-envelope10.css')
    .sass('resources/assets/sass/print-envelope9x6.scss', 'public/dist/print-envelope9x6.css')
    .sass('resources/assets/sass/print-landscape.scss', 'public/dist/print-landscape.css')
    .sass('resources/assets/sass/print-style.scss', 'public/dist/print-style.css')
    .sass('resources/assets/sass/pdf-style.scss', 'public/dist/pdf-style.css');

// Only in production
mix.webpackConfig({
    plugins: [
        //Compress images

        new CopyWebpackPlugin({
          patterns: [
            { from: "resources/assets/images", to: "images/" },
          ],
        })
    ],
});
