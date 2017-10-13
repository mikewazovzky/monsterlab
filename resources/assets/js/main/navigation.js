export default function() {
    // Add inbody class when page reloads
    const hash = $(this).find('li.active a').attr('href');

    if (hash !== '#featured') {
        $('header nav').addClass('inbody');
    } else {
        $('header nav').removeClass('inbody');
    }

    // Add an inbody class to nav when scrollspy event fires
    $('.navbar-fixed-top').on('activate.bs.scrollspy', function () {
        const hash = $(this).find('li.active a').attr('href');
        if (hash !== '#featured') {
            $('header nav').addClass('inbody');
        } else {
            $('header nav').removeClass('inbody');
        }
    });
}
