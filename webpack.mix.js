let mix = require('laravel-mix');

// Compile js assets into app.js
// .. what is prefixfree? do I really need it? can I get rid of it?
mix.js([
        'resources/assets/js/app.js',
        'resources/assets/js/libs/prefixfree/prefixfree.min.js',
    ], 'public/js')
    // Extract libraries into vendor.js to avoid reloading cache
    // .. only npm libs can be extracted ?
   .extract(['vue', 'jquery', 'moment'])
   // Complile js assets specific to a page
   // .js('resources/assets/js/page.js', 'public/js/page.js')
   // Complile sass assets into app.css
   .sass('resources/assets/sass/app.scss', 'public/css')
   // Complile sass assets specific to main page into main.css
   .sass('resources/assets/sass/main.scss', 'public/css')
   .version();
