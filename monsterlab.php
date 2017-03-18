<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Monster Lab</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="js/prefixfree.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>

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
                    <li class="active"><a href="#featured"><?= _('Home'); ?></a></li>
                    <li><a href="#mission"><?= _('Mission'); ?></a></li>
                    <li><a href="#services"><?= _('Services'); ?></a></li>
                    <li><a href="#staff"><?= _('Staff'); ?></a></li>
                    <li><a href="#customers"><?= _('Customers'); ?></a></li>
                    <li><a href="#contacts"><?= _('Contacts'); ?></a></li>
              
                    <?php if($locale == 'en_US') : ?>
                        <li><a href="?lang=ru_RU"><img src="images/ru.png" title="Русский"></a></li>
                    <?php else: ?>
                        <li><a href="?lang=en_US"><img src="images/en.png" title="English"></a></li>
                    <?php endif; ?>	
                
                </ul>        
            </div><!-- collapse navbar-collapse -->
        </div><!-- container -->
    </nav>

    <div class="carousel fade" data-ride="carousel" id="featured">

        <ol class="carousel-indicators"></ol>

        <div class="carousel-inner fullheight">
            <div class="item active"><img src="images/team2.jpg" alt="Team"></div>
            <div class="item"><img src="images/carousel-mike.jpg" alt="Mike"></div>
            <div class="item"><img src="images/carousel-ceila.jpg" alt="Ceila"></div>    
            <div class="item"><img src="images/carousel-sulley.jpg" alt="Sulley"></div>	  
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
        <h2><?= _('Our Mission. The Beauty of Simplicity.'); ?></h2>      
            <div class="row">
                <p class="col-md-4"><?= _('Monster Lab. web  development studio strives to dive deep to understand 
                        customer business. Based on that knowledge, we deliver robust technology to bring our 
                        client to the web for efficient interaction with customers and partners over internet.'); ?>
                </p>
                <p class="col-md-4"><?= _('Our approach is to keep technology as simple as possible still efficient 
                    to do the job. Thus, being an ikea of web development, we bring down time and cost to have our 
                    solution up and running.'); ?>
                </p> 
                <p class="col-md-4"><?= _('We are specifically proud by our ability to minimize cost and effort 
                    required to support our product, still allowing its scaling and further development as 
                    customer business grows and changes.'); ?>
                </p>
            </div><!-- row -->
        </div><!-- content container -->
    </div><!-- mission page -->

    <div class="page" id="services">
        <div class="content container">
            <h2><?= _('Services and Technology'); ?></h2>
            <div class="row">
            
                <article class="service col-md-4 col-sm-6 col-xs-12">
                    <img class="icon" src="images/icon-advice.png" alt="Icon">
                    <h3><?= _('Advisory Service'); ?></h3>
                    <p><?= _('We help customer to understand how they can use mordern technology to fuel their business.'); ?>
                    </p>
                </article>

                <article class="service col-md-4 col-sm-6 col-xs-12">
                    <img class="icon" src="images/icon-bootstrap.png" alt="Icon">
                    <h3><?= _('Web Design'); ?></h3>
                    <p><?= _('Our creative web design team makes it ... just bright!'); ?></p>
                </article>
        
                <div class="clearfix visible-sm-block"></div>

                <article class="service col-md-4 col-sm-6 col-xs-12">
                    <img class="icon" src="images/icon-vue.png" alt="Icon">
                    <h3><?= _('Interactivity'); ?></h3>
                    <p><?= _('Nobody comes back to boring static pages anymore. Modern JavaScript libraries 
                        bring interactivity to your web solution!'); ?>
                    </p>
                </article>
        
                <div class="clearfix visible-md-block"></div>
				<div class="clearfix visible-lg-block"></div>

                <article class="service col-md-4 col-sm-6 col-xs-12">
                    <img class="icon" src="images/icon-php.png" alt="Icon">
                    <h3><?= _('Software Development'); ?></h3>
                    <p><?= _('To build a complex  solution we develop a server side application. 
                        The stack of technologies we rely upon includes PHP and Laravel.'); ?>
                    </p>
                </article>

                <article class="service col-md-4 col-sm-6 col-xs-12">
                    <img class="icon" src="images/icon-sql.png" alt="Icon">
                    <h3><?= _('DataBases'); ?></h3>
                    <p><?= _('Need to handle large amount of data? No problem, we use contemporary 
                        database solution to handle it.'); ?>
                    </p>
                </article>

                <article class="service col-md-4 col-sm-6 col-xs-12">
                    <img class="icon" src="images/icon-service.png" alt="Icon">
                    <h3><?= _('Support'); ?></h3>
                    <p><?= _('Lifetime support is provided to customer. We help you deploy your solution, 
                        support, update and enhance it as needed.'); ?>
                    </p>
                </article> 
        
            </div><!-- row -->   
        </div><!-- content container -->
    </div><!-- services page -->

    <div class="page" id="staff">
        <div class="container-fluid">
            <h2 id="ourstaff"><?= _('Our Staff'); ?></h2>
            <div class="row">

                <div class="employee col-lg-4">
                    <div class="row">
                        <div class="photo col-xs-6 col-xs-offset-3 col-sm-3 col-sm-offset-1 col-md-2 col-md-offset-2 col-lg-4 col-lg-offset-0">
                            <img class="img-circle" src="images/team-sulley.jpg" alt="Photo of Dr Sanders">
                        </div><!-- photo -->
                        <div class="info col-xs-8 col-xs-offset-2 col-sm-7 col-sm-offset-0 col-md-6 col-lg-8">
                            <h3><?= _('James P. Sullivan'); ?></h3>
                            <p><?= _('Sulley is our Senior Developer and Software Architecture design guru. 
                                Pls. never NEVER argue with him!'); ?>
                            </p>
                        </div><!-- info -->
                    </div> <!-- inner row -->
                </div> <!-- employee -->

                <div class="employee col-lg-4">
                    <div class="row">
                        <div class="photo col-xs-6 col-xs-offset-3 col-sm-3 col-sm-offset-1 col-md-2 col-md-offset-2 col-lg-4 col-lg-offset-0">
                            <img class="img-circle" src="images/team-ceila.jpg"  alt="Photo of Dr Sanders">
                        </div><!-- photo -->
                        <div class="info col-xs-8 col-xs-offset-2 col-sm-7 col-sm-offset-0 col-md-6 col-lg-8">
                            <h3><?= _('Celia Mae'); ?></h3>
                            <p><?= _('Our web design team is led by Celia.  I bet you\'ll be absolutly happy by how 
                                it all looks and feels.'); ?>
                            </p>
                        </div><!-- info -->
                    </div> <!-- inner row -->
                </div> <!-- employee -->

                <div class="employee col-lg-4">
                    <div class="row">
                        <div class="photo col-xs-6 col-xs-offset-3 col-sm-3 col-sm-offset-1 col-md-2 col-md-offset-2 col-lg-4 col-lg-offset-0">
                            <img class="img-circle" src="images/team-mike.jpg" alt="Photo of Dr Sanders">
                        </div><!-- photo -->
                        <div class="info col-xs-8 col-xs-offset-2 col-sm-7 col-sm-offset-0 col-md-6 col-lg-8">
                            <h3><?= _('Mike Wazovzky'); ?></h3>
                            <p><?= _('Mike\'s job as a producer is to make you happy. The guy will communicate with you from the original requirement discussion till the <del>end you life</del> celebration of successful solution launch.'); ?></p>
                        </div><!-- info -->
                    </div> <!-- inner row -->
                </div> <!-- employee -->


            </div><!-- outer row -->
        </div><!-- container -->
    </div><!-- staff page -->

    <div class="page" id="customers">
        <div class="container-fluid">
            <h2><?= _('Customer Testimonials'); ?></h2>
            <div class="row">
            
                <blockquote class="col-md-6 col-lg-3" id="randell">
                    <div class="quote">
                        <span class="intro"><?= _('Best EVER web design studio for entrepreners and small businesses'); ?></span>
                        <span class="more"><?= _(' brings your site up and running in no time! Nice people to deal with.'); ?></span>
                        <span class="customer"><?= _('Randell Boggs'); ?></span>
                        <span class="customer"><?= _('entreprener'); ?></span>
                    </div>
                </blockquote>

                <blockquote class="col-md-6 col-lg-3" id="henry">
                    <div class="quote">
                        <span class="intro"><?= _('We need a fairily complex and unique solution for large company. They managed to cope with it'); ?></span>
                        <span class="more"><?= _('I\'m specifically happy on how they organized a post production support!'); ?></span>
                        <span class="customer"><?= _('Henry J. Waternoose'); ?></span>
                        <span class="customer">S<?= _('W Power Inc.'); ?></span>
                    </div>
                </blockquote>

                <blockquote class="col-md-6 col-lg-3" id="roz">
                    <div class="quote">
                        <span class="intro"><?= _('The govermenment agencies like a CDA have a set of specific requirement to service providers'); ?></span>
                        <span class="more"><?= _('Monster Labs worked out for us.'); ?></span>
                        <span class="customer"><?= _('Roz'); ?></span>
                        <span class="customer"><?= _('Child Detection Agency'); ?></span>
                    </div>
                </blockquote>

                <blockquote class="col-md-6 col-lg-3" id="boo">
                    <div class="quote">
                        <span class="intro"><?= _('Not everyone has complex needs and a lot of money. I just wanted to share my drowings with my friends over internet'); ?></span>
                        <span class="more"><?= _('monsters helped me. Now I\'m internet superstar and a millionair. Mom is happy!'); ?></span>
                        <span class="customer"><?= _('Boo'); ?></span>
                    </div>
                </blockquote>          
            </div>
        </div><!-- container -->
    </div><!-- customers page -->

    <div class="page" id="contacts">
        <div class="container-fluid">
            <h2><?= _('Contacts'); ?></h2>
            <div id="contactdata">
                <!--<p><?= _('Phone: '); ?><span class="phone">+7 (222) 222-3-222</span></p>-->
                <p><?= _('Email: '); ?><span class="phone">mike.wazovzky@gmail.com</span></p>			
            </div> <!-- contactdata -->
        </div><!-- container -->
    </div><!-- contacts page --> 
  
</div><!-- main -->

<footer>
    <p>2016-2017, <a href="http://m-lab.xyz">Monster Lab.</a></p>    

<!--------------------------------------------------------------------------------     
	<nav class="navbar navbar-default" role="navigation">
        <ul class="nav navbar-nav navbar-right">
        <li><a href="#">Terms of use</a></li>
        <li><a href="#">Privacy policy</a></li>
        </ul>
    </nav>     
--------------------------------------------------------------------------------->    

</footer>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
<script src="js/myscript.js"></script>
</body>
</html>
