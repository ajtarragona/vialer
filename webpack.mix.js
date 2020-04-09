let mix = require('laravel-mix');

mix.js('src/resources/assets/js/vialer.js', 'src/public/js')
   .sass('src/resources/assets/sass/vialer.scss', 'src/public/css');