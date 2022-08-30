const mix = require('laravel-mix');

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
    .styles([
        'resources/css/all.min.css',
        'resources/css/bootstrap.min.css',
    ],'public/pages/home/css/app.css')
    .js([
        'resources/js/bootstrap.js',
        'resources/js/jquery-3.6.1.js',
        'resources/js/bootstrap.bundle.min.js',
    ],'public/pages/home/js/app.js')
    .version()
