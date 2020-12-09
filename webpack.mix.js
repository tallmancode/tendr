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

mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/frontend.js', 'public/js')
    .js('resources/js/backend.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/sass/front.scss', 'public/css')
    .sass('resources/sass/backend.scss', 'public/css')
    .copyDirectory('resources/assets/media', 'public/media');

if (mix.inProduction()) {
    mix.version();
}

if (!mix.inProduction()) {
    mix.webpackConfig({
        devtool: 'source-map',
    }).sourceMaps()
}
