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
                    <li><a href="/main/ru"><img src="/images/ru.png" title="Русский"></a></li>
                @else
                    <li><a href="/main/en"><img src="/images/en.png" title="English"></a></li>
                @endif

            </ul>
        </div><!-- collapse navbar-collapse -->
    </div><!-- container -->
</nav>
