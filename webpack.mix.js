const { mix } = require('laravel-mix');
const glob = require('@alexbinary/glob');

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

mix.js('resources/assets/js/app.js', 'public/dist/js')
   .sass('resources/assets/sass/app.scss', 'public/dist/css');

glob('public/dist/css/*.css').then((files) => {
  mix.styles(files, 'public/dist/bundle.css').version();
});

glob('public/dist/js/*.js').then((files) => {
  mix.styles(files, 'public/dist/bundle.js').version();
});
   
