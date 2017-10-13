<template>
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#featured"><h1>Monster Lab.<span class="subhead">Software Design</span></h1></a>
            </div><!-- navbar-header -->

            <div class="collapse navbar-collapse" id="collapse">
                <ul class="nav navbar-nav navbar-right main-menu-items">
                    <slot name="menu-items"></slot>
                    <slot name="extra-items"></slot>
                </ul>
            </div><!-- collapse navbar-collapse -->
        </div><!-- container -->
    </nav>
</template>

<script>
    export default {
        mounted() {
            // Variable for menu height
            const topOffset = 50;
            // Activate Scrollspy
            $('body').scrollspy({
                target: 'header .navbar',
                offset: topOffset
            });
            // Change menu size (if required) when scrollspy event fires
            $('.navbar-fixed-top').on('activate.bs.scrollspy', () => this.minimizeMenu());
            // Change menu size (if required) on page load
            this.minimizeMenu();
        },

        methods: {
            // Minimize menu (via adding 'inbody' class) if scrolled out of top section
            minimizeMenu() {
                const hash = $('.main-menu-items').find('li.active a').attr('href');

                if (hash !== '#featured') {
                    $('header nav').addClass('inbody');
                } else {
                    $('header nav').removeClass('inbody');
                }
            }
        }
    };
</script>

<style>

header .navbar {
  padding: 30px 0;
  transition: all .5s ease-out;
}

header .navbar-default {
  background-color: transparent;
  border: none;
}

header .navbar-default .navbar-nav a {
  color: white;
  padding: 5px 8px;
}

header .navbar-default .navbar-nav a:hover {
  color: #EEC856;
}

header .navbar-default .navbar-nav .active a {
  font-weight: 700;
  color: #EEC856;
  background: transparent;
  border-bottom: 4px solid #EEC856;
  text-shadow: none;
}

header .navbar-default .navbar-nav .active a:hover {
  color: #EEC856;  /* #E15D5F;  */
  text-shadow: none;
  background: transparent;
}

header .navbar-brand {
  background: url(../../images/logo.png);
  background-repeat: no-repeat;
  background-position: 15px 0;
  background-size: contain;
  height: auto;
}

header .navbar-brand h1 {
  color: white;
  margin: 0;
  font-size: 1.8em;
  font-weight: 400;
  padding-left: 100px;
}

@media only screen
and (max-width: 999px) {
  header .navbar-brand {
    display: none;
  }
}

header .navbar-brand span.subhead {
  display: block;
  font-family: "Roboto Slab", serif;
  font-size: .6em;
  font-weight: 100;
}

/* header .navbar-toggle { background-color: #279182; } */

header .navbar-default .navbar-toggle .icon-bar {
  background-color: white;
}

@media only screen
and (max-width: 768px) {
  header .navbar-collapse.in {
    background-color: rgba(0,0,0, .5);
  }
}

header .inbody {
  background: rgba(0,133,202,.9);
}

header .navbar.inbody {
  padding-top: 0;
  padding-bottom: 0;
}

header .navbar.inbody .navbar-nav {
  padding-top: 10px;
}

header .inbody .navbar-brand {
  background-size: 43px;
  background-position: top left;
  margin-top: 5px;
  padding-bottom: 0;
  margin-left: 10px;
}

header .inbody .navbar-brand h1 {
  font-size: 1.1em;
  padding-left: 38px;
  margin-top: 5px;
}

header .inbody .navbar-brand {
  display: none;
}
</style>
