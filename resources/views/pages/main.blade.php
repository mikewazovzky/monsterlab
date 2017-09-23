@extends('layouts.app')

@section('header')
    <link rel="stylesheet" href="/css/style.css">
    <script src="/js/prefixfree.min.js"></script>
@endsection

@section('content')
<header>
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
                <ul class="nav navbar-nav navbar-right">
                    <li class="active"><a href="#featured">{{ __('Home') }}</a></li>
                    <li><a href="#mission">{{ __('Mission') }}</a></li>
                    <li><a href="#services">{{ __('Services') }}</a></li>
                    <li><a href="#staff">{{ __('Staff') }}</a></li>
                    <li><a href="#customers">{{ __('Customers') }}</a></li>
                    <li><a href="#contacts">{{ __('Contacts') }}</a></li>

                    @if($locale == 'en')
                        <li><a href="/ru"><img src="/images/ru.png" title="Русский"></a></li>
                    @else
                        <li><a href="/en"><img src="/images/en.png" title="English"></a></li>
                    @endif

                </ul>
            </div><!-- collapse navbar-collapse -->
        </div><!-- container -->
    </nav>

    <div class="carousel fade" data-ride="carousel" id="featured">
        <ol class="carousel-indicators"></ol>
        <div class="carousel-inner fullheight">
            <div class="item active"><img src="/images/team2.jpg" alt="Team"></div>
            <div class="item"><img src="/images/carousel-mike.jpg" alt="Mike"></div>
            <div class="item"><img src="/images/carousel-ceila.jpg" alt="Ceila"></div>
            <div class="item"><img src="/images/carousel-sulley.jpg" alt="Sulley"></div>
        </div><!-- carousel-inner -->

        <a class="left carousel-control" href="#featured" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left"></span>
        </a>
        <a class="right carousel-control" href="#featured" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right"></span>
        </a>
    </div><!-- featured carousel -->
</header>

<div class="main">
    <div class="page" id="mission">
        <div class="content container">
        <h2>{{ __('Our Mission. The Beauty of Simplicity.') }}</h2>
            <div class="row">
                <p class="col-md-4">{{ __('Monster Lab. web  development studio strives to dive deep to understand customer business. Based on that knowledge, we deliver robust technology to bring our client to the web for efficient interaction with customers and partners over internet.') }}</p>
                <p class="col-md-4">{{ __('Our approach is to keep technology as simple as possible still efficient to do the job. Thus, being an ikea of web development, we define stack of technologies that fits best project requirements and brings down time and cost to have our solution up and running.') }}</p>
                <p class="col-md-4">{{ __('We are specifically proud by our ability to minimize cost and effort required to support our product, still allowing its scaling and further development as customer business grows and changes.') }}</p>
            </div><!-- row -->
        </div><!-- content container -->
    </div><!-- mission page -->

    <div class="page" id="services">
        <div class="content container">
            <h2>{{ __('Services and Technology') }}</h2>
            <div class="row">

                <article class="service col-md-4 col-sm-6 col-xs-12">
                    <img class="icon" src="/images/icon-advice.png" alt="Icon">
                    <h3>{{ __('Advisory Service') }}</h3>
                    <p>{{ __('We help customer to understand how they can use mordern technology to drive the business.') }}</p>
                </article>

                <article class="service col-md-4 col-sm-6 col-xs-12">
                    <img class="icon" src="/images/icon-bootstrap.png" alt="Icon">
                    <h3>{{ __('Web Design') }}</h3>
                    <p>{{ __('Our creative web design team makes it ... just bright!') }}</p>
                </article>

                <div class="clearfix visible-sm-block"></div>

                <article class="service col-md-4 col-sm-6 col-xs-12">
                    <img class="icon" src="/images/icon-vue.png" alt="Icon">
                    <h3>{{ __('Interactivity') }}</h3>
                    <p>{{ __('Nobody comes back to boring static pages anymore. Modern JavaScript libraries bring interactivity to your web solution!') }}</p>
                </article>

                <div class="clearfix visible-md-block"></div>
                <div class="clearfix visible-lg-block"></div>

                <article class="service col-md-4 col-sm-6 col-xs-12">
                    <img class="icon" src="/images/icon-php.png" alt="Icon">
                    <h3>{{ __('Software Development') }}</h3>
                    <p>{{ __('To build a complex  solution we develop a server side application. The stack of technologies we rely upon includes PHP and Laravel.') }}</p>
                </article>

                <div class="clearfix visible-sm-block"></div>

                <article class="service col-md-4 col-sm-6 col-xs-12">
                    <img class="icon" src="/images/icon-sql.png" alt="Icon">
                    <h3>{{ __('DataBases') }}</h3>
                    <p>{{ __('Need to handle large amount of data? No problem, we use contemporary database solution to manage it.') }}</p>
                </article>

                <article class="service col-md-4 col-sm-6 col-xs-12">
                    <img class="icon" src="/images/icon-service.png" alt="Icon">
                    <h3>{{ __('Support') }}</h3>
                    <p>{{ __('Lifetime support is provided to customer. We deploy and host the solution, update and enhance it as needed, provide required training.') }}</p>
                </article>

            </div><!-- row -->
        </div><!-- content container -->
    </div><!-- services page -->

    <div class="page" id="staff">
        <div class="container-fluid">
            <h2 id="ourstaff">{{ __('Our Staff') }}</h2>
            <div class="row">

                <div class="employee col-lg-4">
                    <div class="row">
                        <div class="photo col-xs-6 col-xs-offset-3 col-sm-3 col-sm-offset-1 col-md-2 col-md-offset-2 col-lg-4 col-lg-offset-0">
                            <img class="img-circle" src="/images/team-sulley.jpg" alt="Photo of Dr Sanders">
                        </div><!-- photo -->
                        <div class="info col-xs-8 col-xs-offset-2 col-sm-7 col-sm-offset-0 col-md-6 col-lg-8">
                            <h3>{{ __('James P. Sullivan') }}</h3>
                            <p>{{ __('Sulley is our Senior Developer and Software Architecture design guru. Pls. never NEVER argue with him!') }}</p>
                        </div><!-- info -->
                    </div> <!-- inner row -->
                </div> <!-- employee -->

                <div class="employee col-lg-4">
                    <div class="row">
                        <div class="photo col-xs-6 col-xs-offset-3 col-sm-3 col-sm-offset-1 col-md-2 col-md-offset-2 col-lg-4 col-lg-offset-0">
                            <img class="img-circle" src="/images/team-ceila.jpg"  alt="Photo of Dr Sanders">
                        </div><!-- photo -->
                        <div class="info col-xs-8 col-xs-offset-2 col-sm-7 col-sm-offset-0 col-md-6 col-lg-8">
                            <h3>{{ __('Celia Mae') }}</h3>
                            <p>{{ __('Our web design team is led by Celia.  I bet you\'ll be absolutly happy by how it all looks and feels.') }}</p>
                        </div><!-- info -->
                    </div> <!-- inner row -->
                </div> <!-- employee -->

                <div class="employee col-lg-4">
                    <div class="row">
                        <div class="photo col-xs-6 col-xs-offset-3 col-sm-3 col-sm-offset-1 col-md-2 col-md-offset-2 col-lg-4 col-lg-offset-0">
                            <img class="img-circle" src="/images/team-mike.jpg" alt="Photo of Dr Sanders">
                        </div><!-- photo -->
                        <div class="info col-xs-8 col-xs-offset-2 col-sm-7 col-sm-offset-0 col-md-6 col-lg-8">
                            <h3>{{ __('Mike Wazovzky') }}</h3>
                            <p>{{ __('Mike\'s job as a producer is to make you happy. The guy will stay in touch with you 24x7 till the successful solution launch.') }}</p>
                        </div><!-- info -->
                    </div> <!-- inner row -->
                </div> <!-- employee -->


            </div><!-- outer row -->
        </div><!-- container -->
    </div><!-- staff page -->

    <div class="page" id="customers">
        <div class="container-fluid">
            <h2>{{ __('Customer Testimonials') }}</h2>
            <div class="row">

                <blockquote class="col-md-6 col-lg-3" id="randell">
                    <div class="quote">
                        <span class="intro">{{ __('Best EVER web design studio for entrepreners and small business') }}</span>
                        <span class="more">{{ __(' brings your site up and running in no time! Nice people to deal with.') }}</span>
                        <span class="customer">{{ __('Randell Boggs') }}</span>
                        <span class="customer">{{ __('entreprener') }}</span>
                    </div>
                </blockquote>

                <blockquote class="col-md-6 col-lg-3" id="henry">
                    <div class="quote">
                        <span class="intro">{{ __('We need a fairily complex and unique solution for large company. They managed to cope with it') }}</span>
                        <span class="more">{{ __('I\'m specifically happy on how they organized a post production support!') }}</span>
                        <span class="customer">{{ __('Henry J. Waternoose') }}</span>
                        <span class="customer">{{ __('SW Power Inc.') }}</span>
                    </div>
                </blockquote>

                <blockquote class="col-md-6 col-lg-3" id="roz">
                    <div class="quote">
                        <span class="intro">{{ __('The govermenment agencies like a CDA have a set of specific requirement to service providers') }}</span>
                        <span class="more">{{ __('Monster Labs worked out for us.') }}</span>
                        <span class="customer">{{ __('Roz') }}</span>
                        <span class="customer">{{ __('Child Detection Agency') }}</span>
                    </div>
                </blockquote>

                <blockquote class="col-md-6 col-lg-3" id="boo">
                    <div class="quote">
                        <span class="intro">{{ __('Not everyone has complex needs and a lot of money. I just wanted to share my drowings with my friends over internet') }}</span>
                        <span class="more">{{ __('monsters helped me. Now I\'m internet star and a millionair. Mom is happy!') }}</span>
                        <span class="customer">{{ __('Boo') }}</span>
                    </div>
                </blockquote>
            </div>
        </div><!-- container -->
    </div><!-- customers page -->

    <div class="page" id="contacts">
        <div class="container-fluid">
            <h2>{{ __('Contacts') }}</h2>
            <div id="contactdata">
                <p>{{ __('Phone') }}: <span class="phone">+7 (222) 222-3-222</span></p>
                <p>{{ __('Email') }}: <span class="phone">mike.wazovzky@gmail.com</span></p>
                <p v-text="contactsMessage"></p>
            </div> <!-- contactdata -->
        </div><!-- container -->
    </div><!-- contacts page -->

</div><!-- main -->

<footer id="footer">
    <p v-text="message"></p>
    <p>2016-2017, <a href="http://m-lab.xyz">Monster Lab.</a></p>
</footer>

@endsection

@section('footer')
    <script src="/js/myscript.js"></script>
@endsection
