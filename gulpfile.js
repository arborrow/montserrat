var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.sass('app.scss');
    mix.styles([
        'bootstrap.css',
        'bootstrap-adaptive-tabs.css',
        'jquery.datetimeentry.css',
        'jquery-ui.css',
        'select2.css',
        'style.css'
    ],null,'public/css');
    mix.scripts([
        'jquery.js',
        'jquery.plugin.js',
        'jquery-ui.js',
        'bootstrap.js',
        'jquery.datetimeentry.js',
        'select2.js'
    ],null,'public/js');
    mix.version(['public/css/all.css','public/js/all.js'],'public');
    
});
