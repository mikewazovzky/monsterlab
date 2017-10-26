@extends('posts.layout')

@section('main')

    <div class="page-header">
        <h1>Контакты</h1>
    </div>

    <div class="row">
        <div class="contacts col-sm-4">
            <p><span class="glyphicon glyphicon-map-marker"></span> Адрес:<br>Космодамианская набережная 52/2<br>Москва, Россия</p>
            <p><span class="glyphicon glyphicon-phone"></span> Телефон:<br>+7 (xxx) xxx xx-xx</p>
            <p><span class="glyphicon glyphicon-envelope"></span> Электронная почта:<br><a href="">mike.wazovzky@gmail.com</a></p>
        </div>

        <div class="contacts col-sm-8">
            <iframe width="480" height="300" frameborder="0" style="border:0; display: block;  margin: 0 auto;" src="https://www.google.com/maps/embed/v1/place?q=place_id:ChIJgQtiNeBKtUYR2tvvcHt7ZE4&key=AIzaSyCk1tk4ulh8FQpW91l9vCn7c2ze5isgOd0" allowfullscreen></iframe>
        </div>
    </div>

    <hr>

    <div class="row">
        <h3 class="text-center">Отправить сообщение</h3>

        <form class="form-horizontal" method="POST" action="{{ route('feedback') }}">
            {{ csrf_field() }}

            <div class="form-group">
                <label for="name"  class="control-label col-sm-3 col-sm-offset-1">Имя:</label>
                <div class="col-sm-6">
                    <input type="text" name="name" class="form-control" placeholder="Введите имя" />
                </div>
            </div>

            <div class="form-group">
                <label for="email" class="control-label col-sm-3 col-sm-offset-1">Электронная почта:</label>
                <div class="col-sm-6">
                    <input type="email" name="email" class="form-control"  placeholder="Введите адрес электронной почты"/>
                </div>
            </div>

            <div class="form-group">
                <label for="subj" class="control-label col-sm-3 col-sm-offset-1">Тема сообщения:</label>
                <div class="col-sm-6">
                    <input type="text" name="subj" class="form-control" placeholder="Введите тему сообщения"/>
                </div>
            </div>

            <div class="form-group">
                <label for="body" class="control-label col-sm-3 col-sm-offset-1">Сообщение:</label>
                <div class="col-sm-6">
                    <textarea name="body" class="form-control" rows="5" placeholder="Текст сообщения" ></textarea>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-4 col-sm-6">
                    <input type="submit" value="Отправить" class="btn btn-info"/>
                </div>
            </div>

            @include('layouts.errors')

        </form>
    </div>
@endsection
