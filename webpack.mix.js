const mix = require('laravel-mix');

var LiveReloadPlugin = require('webpack-livereload-plugin');



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
//JS
    .js('resources/js/app.js', 'public/js')
    .scripts('resources/views/Admin/assets/js/app.min.js', 'public/admin/assets/js/app.min.js')
    .scripts('resources/views/Admin/assets/js/vendor.min.js', 'public/admin/assets/js/vendor.min.js')
    // plugins
    .scripts('node_modules/parsleyjs/dist/parsley.min.js', 'public/admin/assets/libs/parsley.min.js')
    .scripts('node_modules/selectize/dist/js/selectize.min.js', 'public/admin/assets/libs/selectize.min.js')
    .scripts('node_modules/mohithg-switchery/dist/switchery.min.js', 'public/admin/assets/libs/switchery.min.js')
    .scripts('node_modules/multiselect/js/jquery.multi-select.js', 'public/admin/assets/libs/jquery.multi-select.js')
    .scripts('node_modules/select2/dist/js/select2.min.js', 'public/admin/assets/libs/select2.min.js')
    .scripts('node_modules/jquery-mockjax/dist/jquery.mockjax.min.js', 'public/admin/assets/libs/jquery.mockjax.min.js')
    .scripts('node_modules/devbridge-autocomplete/dist/jquery.autocomplete.min.js', 'public/admin/assets/libs/jquery.autocomplete.min.js')
    .scripts('node_modules/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js', 'public/admin/assets/libs/jquery.bootstrap-touchspin.min.js')
    .scripts('node_modules/bootstrap-maxlength/dist/bootstrap-maxlength.min.js', 'public/admin/assets/libs/bootstrap-maxlength.min.js')
    // Pages
    .scripts('resources/views/Admin/assets/js/pages/form-validation.init.js', 'public/admin/assets/js/pages/form-validation.init.js')
    .scripts('resources/views/Admin/assets/js/pages/form-advanced.init.js', 'public/admin/assets/js/pages/form-advanced.init.js')

//CSS
.styles('resources/views/Admin/assets/css/config/bootstrap.min.css', 'public/admin/assets/css/config/bootstrap.min.css')
    .styles('resources/views/Admin/assets/css/config/app.min.css', 'public/admin/assets/css/config/app.min.css')
    .styles('resources/views/Admin/assets/css/config/bootstrap-dark.min.css', 'public/admin/assets/css/config/bootstrap-dark.min.css')
    .styles('resources/views/Admin/assets/css/config/app-dark.min.css', 'public/admin/assets/css/config/app-dark.min.css')
    .styles('resources/views/Admin/assets/css/icons.min.css', 'public/admin/assets/css/icons.min.css')
    .styles([
        'node_modules/mohithg-switchery/dist/switchery.min.css',
        'node_modules/multiselect/css/multi-select.css',
        'node_modules/select2/dist/css/select2.min.css',
        'node_modules/selectize/dist/css/selectize.bootstrap3.css',
        'node_modules/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css',
    ], 'public/admin/assets/libs/app.min.css')

//SASS
.sass('resources/sass/app.scss', 'public/css')

//CONFIG
.autoload({
        'jquery': ['$', 'window.jQuery', 'jQuery']
    })
    .sourceMaps()
    .version()