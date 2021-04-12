const mix = require('laravel-mix');
const path = require("path");

mix.js('resources/js/app.js', 'public/js')
    .vue()
    .sass('resources/sass/app.scss', 'public/css')
    .webpackConfig({
        resolve: {
            extensions: [".js", ".vue"],
            alias: {
                "@": path.resolve("resources/js"),
            }
        }
    });



mix.browserSync ( 'https://dev4s.run.goorm.io/');
