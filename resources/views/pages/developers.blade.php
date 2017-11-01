@extends('layouts.app')

@section('header')
    <style>
        #section-1 { margin-top: 0; }
        .menu ul { list-style-type: square; padding-left: 1em; }
        .section { font-size: 1.2em; }
        .content { text-align: justify; }
    </style>
@endsection

@section('content')

<div class="container">

<div class="page-header">
    <h1>Разработчикам: M-lab API</h1>
</div>

<div class="dev row">

<div class="menu col-md-3">
<a class="section" href="#section-1">Обзор</a><br>
<a class="section" href="#section-2">Использование API</a>
<ul>
    <li><a href="#article-2-1">Аутентификация пользователей</a></li>
    <li><a href="#article-2-2">Выполнение запроса</a></li>
    <li><a href="#article-2-3">Формат ответа</a></li>
    <li><a href="#article-2-4">Сообщения об ошибках</a></li>
</ul>
<a class="section" href="#section-3">Справочник API</a>
<ul>
    <li><a href="#article-3-1">Получение записей</a></li>
    <li><a href="#article-3-2">Создание записи</a></li>
    <li><a href="#article-3-3">Редактирование записи</a></li>
    <li><a href="#article-3-4">Удаление записи</a></li>
</ul>

</div> {{-- Menu --}}
<div class="content col-md-9">
<h3 id="section-1">Обзор</h3>
<p>Зарегистрированные пользователи сайта имеют возможность создать на сайте клиента для
осуществления удаленного доступа к контенту от их имени и с имеющимися у них полномочиями.</p>
<p>Сайт предоставляет возможность удаленного доступа к операциям получения данных
(набора записей), создания новых записей, их редактирования и удаления.</p>

<h3 id="section-2">Использование API</h3>
<h4 id="article-2-1">Аутентификация пользователей</h4>
<p>Аутентификация пользователей осуществляется в соответствии с потоколом OAuth2.</p>
<p>Для создания клиента удаленного доступа необходимо перейти в <a href="#">панель управления
удаленным доступом</a>, создать клиента, указать его имя (Name) и адрес для переадресации
(Redirect URL) при регистрации приложения, запомнить его id (Client ID) и маркер
доступа (Secret)</p>
<p>При первом обращении приложения к сайту будет запрошено в интерактивном режиме подтвержение
полномочий приложения на выполнени операций от имени пользователя.</p>
<p>После получения подтверждение приложению будет передан по указанному адресу
переадресации (Redirect URL) код доступа (code).
Полученный код приложение должно обменять на маркер доступа (access token) на основании
которого будет осуществлятся аутентификация пользователя при обработке запросов
приложения к сайту.</p>
<p> При последующих обращениях приложения к сайту подтверждение полномочий и
переадресация будет производиться автоматически без взаимодействия с пользователем.</p>

<h4 id="article-2-2">Выполнение запроса</h4>
<p>Обращение к API сайта осуществляется посредством HTTP запросов.
В приведенном ниже справочнике (Reference API) приведены доступные пользователю
запросы (METHOD, URL) и перечень передаваемых параметров.</p>

<h4 id="article-2-3">Формат ответа</h4>
<p>В ответ на запрос сайт возвращает статус ответа (HTTP code) и запрошенные
данные в формате JSON. Параметры возвращаемого ответа приведены в справочнике API.</p>

<h4 id="article-2-4">Сообщения об ошибках</h4>
<p>В случае ошибки запрос возвращает статус ошибки и ее описание в формате</p>
<pre><code>
{
    "message": "Something went completly wrong.",
    "errors": {
        "errorName": [
            "Error description."
        ]
    }
}
</code></pre>

<h3 id="section-3">Справочник (API Reference)</h3>

<h4 id="article-3-1">Получение записей</h4>
<p>Получение массива записей соответствующих определенному пользователем критерию.
В случае отсутствия записей, соответствующих запросу, возвращается пустой массив.</p>
<pre><code>
GET  HTTP/1.1
URL: http://m-lab.xyz/api/v1.01/
</code></pre>
<p><strong>Права доступа</strong> Зарегистрированные пользователи c ролями <strong>reader, writer</strong></p>
<p><strong>Параметры запроса</strong> Параметры запроса можно комбинировать</p>
<table class="table table-condensed fs-08">
    <tr>
        <th>Параметр</th>
        <th>Обязательный</th>
        <th>Описание</th>
        <th>Тип</th>
    </tr>
    <tr>
        <td>id</td>
        <td>нет</td>
        <td>Идентификатор записи (поста). Возвращает массив с одной записью с указанным id, если он существует</td>
        <td>integer</td>
    </tr>
    <tr>
        <td>tag</td>
        <td>нет</td>
        <td>Возвращает массив записей имеющих указанный тэг</td>
        <td>string</td>
    </tr>
    <tr>
        <td>year</td>
        <td>нет</td>
        <td>Возвращает массив записей опубликованных в указанном году</td>
        <td>string</td>
    </tr>
    <tr>
        <td>month</td>
        <td>нет</td>
        <td>Возвращает массив записей опубликованных в указанном месяце</td>
        <td>string</td>
    </tr>
</table>
<p><strong>Ответ сервера.</strong></p>
<p>Сервер возвращает JSON объект с массивом данных,
каждому элементу которого соответсвует одна запись (post).
Если записей соответствующих запросу не найдено, возвращается пустой массив.</p>
<pre><code>
HTTP/1.1 200 OK
Content-Type: application/json

{
    "data": [
        {
            "id": "733",
            "title": "Some title",
            "body": "Post body text",
            "tags": [
                "PHP",
                "Laravel"
            ],
            "user": {
                "name": "Author name",
                "slug": "User profile slug"
            }
        }
    ]
}
</code></pre>

<br>
<h4 id="article-3-2">Создание записи</h4>
<p>Создание новой записи</p>
<pre><code>
POST HTTP/1.1
URL: http://m-lab.xyz/api/v1.01/
</code></pre>
<p><strong>Права доступа</strong> Зарегистрированные пользователи c ролями <strong>writer</strong></p>
<p><strong>Параметры запроса</strong></p>
<table class="table table-condensed fs-08">
    <tr>
        <th>Параметр</th>
        <th>Обязательный</th>
        <th>Описание</th>
        <th>Тип</th>
    </tr>
    <tr>
        <td>title</td>
        <td>да</td>
        <td>Заголовок статьи</td>
        <td>string</td>
    </tr>
    <tr>
        <td>body</td>
        <td>да</td>
        <td>Текст статьи</td>
        <td>string</td>
    </tr>
    <tr>
        <td>tags</td>
        <td>нет</td>
        <td>Массив тэгов, допускается только использование существующих тэгов, иначе они будут проигнориованы.</td>
        <td>array</td>
    </tr>
</table>
<p><strong>Ответ сервера.</strong></p>
<p>Сервер возвращает JSON объект с описанием созданной записи данных в случае успеха или
в случае ошибки массив с ее описанием.</p>
<pre><code>
HTTP/1.1 201 OK
Content-Type: application/json

{
    {
        "id": "733",
        "title": "Some title",
        "body": "Post body text",
        "tags": [
            "PHP",
            "Laravel"
        ]
    }
}
</code></pre>

<br>
<h4 id="article-3-3">Редактирование записи</h4>
<p>Внесение изменений в существующую запись.</p>
<pre><code>
POST HTTP/1.1
URL: http://m-lab.xyz/api/v1.01/{$post_id}/update
</code></pre>
<p><strong>Права доступа</strong> Пользователь создавший запись (<strong>writer</strong>)</p>
<p><strong>Параметры запроса</strong></p>
<table class="table table-condensed fs-08">
    <tr>
        <th>Параметр</th>
        <th>Обязательный</th>
        <th>Описание</th>
        <th>Тип</th>
    </tr>
    <tr>
        <td>title</td>
        <td>нет</td>
        <td>Заголовок статьи</td>
        <td>string</td>
    </tr>
    <tr>
        <td>body</td>
        <td>нет</td>
        <td>Текст статьи</td>
        <td>string</td>
    </tr>
    <tr>
        <td>tags</td>
        <td>нет</td>
        <td>Массив тэгов. При наличии парамера, массив тэгов записи будет синхронизирован (заменен) с
        переданным массивом. Допускается только использование существующих тэгов,
        не существующие тэги будут проигнориованы.</td>
        <td>array</td>
    </tr>
</table>
<p><strong>Ответ сервера.</strong></p>
<p>Сервер возвращает со статусом "success" в случае успеха или, в случае ошибки, массив с ее описанием.</p>
<pre><code>
HTTP/1.1 200 OK
Content-Type: application/json

{
    "status": "success",
}
</code></pre>

<br>
<h4 id="article-3-4">Удаление записи</h4>
<pre><code>
POST HTTP/1.1
URL: http://m-lab.xyz/api/v1.01/{$post_id}/destroy
</code></pre>
<p><strong>Права доступа</strong> Пользователь создавший запись (<strong>writer</strong>).</p>
<p><strong>Параметры запроса:</strong> нет</p>
<p><strong>Ответ сервера.</strong></p>
<p>Сервер возвращает со статусом "success" в случае успеха или, в случае ошибки, массив с ее описанием.</p>
<pre><code>
HTTP/1.1 200 OK
Content-Type: application/json

{
    "status": "success",
}
</code></pre>
</div> {{-- content col-md-8 --}}
</div> {{-- dev row --}}
</div> {{-- container --}}
@endsection
