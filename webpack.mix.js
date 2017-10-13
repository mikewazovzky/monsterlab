let mix = require('laravel-mix');

// Compile js assets into app.js
// .. what is prefixfree? can I get rid of it?
mix.js([
        'resources/assets/js/app.js',
        'resources/assets/js/libs/prefixfree/prefixfree.min.js',
        'resources/assets/js/libs/select2/select2.min.js',
    ], 'public/js')
    // Extract libraries into vendor.js to avoid reloading cache
    // .. only npm libs can be extracted ?
   .extract(['vue', 'jquery', 'moment'])
   // Complile js assets specific to a blog
   // .. get rid of it, transfer into tags vue component
   .js('resources/assets/js/tags.js', 'public/js/blog.js')
   // Complile js assets specific to main page
   // .. get rid of it, turn into vue component(s)
   .js('resources/assets/js/main.js', 'public/js/main.js')
   // Complile sass assets into app.css
   .sass('resources/assets/sass/app.scss', 'public/css')
   // Complile sass assets specific to main page into main.css
   .sass('resources/assets/sass/main.scss', 'public/css')
   // Combine app.css with library specific css
   .combine([
        'resources/assets/css/libs/select2/select2.min.css',
        'public/css/app.css',
    ], 'public/css/app.css')
   .version();
