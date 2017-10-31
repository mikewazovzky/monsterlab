{{-- ABOUT IMAGE PANEL --}}
<div class="panel panel-primary">
    <div class="panel-body panel-about">
        <div>
            <img width="100%" src="/images/about.jpg" alt="Monster Lab. Team">
        </div>
    </div>
</div>

{{-- ABOUT DATA PANEL --}}
<div class="panel panel-primary">
    <div class="panel-body">
        <ul class="terms">
            <li><a href="{{ route('about')}}">О проекте</a></li>
            <li><a href="#">Условия использования</a></li>
            <li><a href="#">Политика конфиденциальности</a></li>
            <li><a href="{{ route('developers') }}">Разработчикам</a></li>
            <li><a href="#">Рекламa</a></li>
            <li><a href="{{ route('contacts') }}">Контакты</a></li>
        </ul>
    </div>
    <div class="panel-footer center">
        <span><a href="/main">Monster-Lab, 2017</a></span>
    </div>
</div>
