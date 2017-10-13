webpackJsonp([2],{

/***/ "./resources/assets/js/main.js":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__main_navigation__ = __webpack_require__("./resources/assets/js/main/navigation.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__main_scrollspy__ = __webpack_require__("./resources/assets/js/main/scrollspy.js");



Object(__WEBPACK_IMPORTED_MODULE_0__main_navigation__["a" /* default */])();
Object(__WEBPACK_IMPORTED_MODULE_1__main_scrollspy__["a" /* default */])();

/***/ }),

/***/ "./resources/assets/js/main/navigation.js":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony default export */ __webpack_exports__["a"] = (function () {
    // Add inbody class when page reloads
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
});

/***/ }),

/***/ "./resources/assets/js/main/scrollspy.js":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony default export */ __webpack_exports__["a"] = (function () {
  // Variable for menu height
  var topoffset = 50;
  // Activate Scrollspy
  $('body').scrollspy({
    target: 'header .navbar',
    offset: topoffset
  });

  //Use smooth scrolling when clicking on navigation
  /*************************************************
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
  ***************************************************/
});

/***/ }),

/***/ 2:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__("./resources/assets/js/main.js");


/***/ })

},[2]);