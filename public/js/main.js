webpackJsonp([3],{

/***/ "./resources/assets/js/main.js":
/***/ (function(module, exports) {

$(function someFunction() {

    var slideqty = $('#featured .item').length;
    var wheight = window.innerHeight; // get the height of the window
    var randSlide = Math.floor(Math.random() * slideqty);

    $('#featured .item').eq(randSlide).addClass('active');

    $('.fullheight').css('height', wheight); // set to window tallness

    // replace IMG inside carousels with a background image
    $('#featured .item img').each(function () {
        var imgSrc = $(this).attr('src');
        $(this).parent().css({ 'background-image': 'url(' + imgSrc + ')' });
        $(this).remove();
    });

    // adjust height of .fullheight elements on window resize
    $(window).resize(function () {
        wheight = window.innerHeight; // get the height of the window
        $('.fullheight').css('height', wheight); // set to window tallness
    });

    // Activate Scrollspy
    var topoffset = 50; // variable for menu height
    $('body').scrollspy({
        target: 'header .navbar',
        offset: topoffset
    });

    // add inbody class wheN page reloads
    var hash = $(this).find('li.active a').attr('href');

    if (hash !== '#featured') {
        $('header nav').addClass('inbody');
    } else {
        $('header nav').removeClass('inbody');
    }

    // Add an inbody class to nav when scrollspy event fires
    $('.navbar-fixed-top').on('activate.bs.scrollspy', function () {
        var hash = $(this).find('li.active a').attr('href');
        if (hash !== '#featured') {
            $('header nav').addClass('inbody');
        } else {
            $('header nav').removeClass('inbody');
        }
    });

    /*   //Use smooth scrolling when clicking on navigation
    $('.navbar a[href*=#]:not([href=#])').click(function() {
    if (location.pathname.replace(/^\//,'') ===
      this.pathname.replace(/^\//,'') &&
      location.hostname === this.hostname) {
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
      if (target.length) {
        $('html,body').animate({
          scrollTop: target.offset().top-topoffset+2
        }, 500);
        return false;
      } //target.length
    } //click function
    }); //smooth scrolling
    */

    // Automatically generate carousel indicators
    for (var i = 0; i < slideqty; i++) {
        var insertText = '<li data-target="#featured" data-slide-to="' + i + '"';
        if (i === randSlide) {
            insertText += ' class="active" ';
        }
        insertText += '></li>';
        $('#featured ol').append(insertText);
    }

    $('.carousel').carousel({
        pause: false
    });
});

/***/ }),

/***/ 2:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__("./resources/assets/js/main.js");


/***/ })

},[2]);