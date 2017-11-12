@extends('posts.layout')

@section('main')

    <div class="page-header">
        <h1>О проекте</h1>
    </div>
    <p>
        В блоге публикуются заметки, посвященные вэб программированию.
        Заметки появляются по мере знакомства автора с различными технологиями и
        представляют собой написанное для себя краткое описание особенностей их использования
        или инструкцию (step-by-step guide) по их применению.
    </p>
    <h4>Технологии и сервисы</h4>
    <p>
        Проект реализован на базе следующих технологий и сервисов:
        <ul>
            <li>Backend: PHP/<a href="https://laravel.com/">Laravel</a></li>
            <li>
                Frontend:
                JavaScript/
                <a href="https://vuejs.org/">Vue</a>,
                <a href="https://getbootstrap.com/docs/3.3/">Bootstrap3</a>,
                SASS
            </li>
            <li>Database: mySQL (production), sqlite (testing)</li>
            <li>
                Search Engine(s):
                <a href="https://www.algolia.com/">Algolia</a>,
                <a href="https://www.elastic.co/products/elasticsearch">ElasticSearch</a>
            </li>
            <li>Caching/Queues management: <a href="https://redis.io/">Redis</a></li>
            <li>Project bundling: <a href="https://webpack.github.io/">webpack</a></li>
            <li>Testing: <a href="https://phpunit.de/manual/current/en/installation.html">PHPUnit</a></li>
            <li>
                Continuous Integration:
                <a href="https://travis-ci.org/">Travis CI</a>,
                <a href="https://coveralls.io/">Coveralls</a>
            </li>
            <li>Hosting: <a href="https://beget.com/ru">beget.com</a></li>
        </ul>
    </p>

    <h4>Компоненты проекта</h4>
    <list-group inline-template>
        <div>
            Основные компоненты проекта и их краткое описание.
            <a href="#" @click.prevent="open">open all</a> /
            <a href="#" @click.prevent="close">close all</a>
            <ul class="list-group">
                <list-item :show="show">
                    <a slot="href">Users/Profiles</a>
                    <p>
                        Пользователи могут просматривать содержание сайта и, после регистрации
                        (требуется подтверждение адреса электронной почты),
                        публиковать заметки (посты), добавлять комментарии,
                        изменять данные в личном кабинете.
                    </p>
                </list-item>

                <list-item :show="show">
                    <a slot="href">Authorization System</a>
                    <p>
                        Система авторизации определяет полномочия пользователя по созданию и редактированию
                        контента в соответсвии с его ролью:
                        <code>guest</code>, <code>reader</code>, <code>writer</code>, <code>admin</code>.
                    </p>
                </list-item>

                <list-item :show="show">
                    <a slot="href">Posts</a>
                    <p>
                        Основное содержание сайта - заметки (посты).
                        Пользователь может создавать, редактировать и удалять свои заметки.
                    </p>
                </list-item>

                <list-item :show="show">
                    <a slot="href">Tags</a>
                    <p>
                        Пост может быть классифицирован с помощью существующих или
                        новых (созданных пользователем) тэгов.
                    </p>
                </list-item>

                <list-item :show="show">
                    <a slot="href">Filtering</a>
                    <p>
                        Посты можно фильтровать и сортировать по различным критериям,
                        например по тегам, году и месяцу создания, количеству просмотров
                        и лайков.
                    </p>
                </list-item>

                <list-item :show="show">
                    <a slot="href">Search: database, Algolia, ElasticSearch</a>
                    <p>
                        Полнотекстовый поиск постов содержащих ключевые слова осуществляется
                        с использованием прямого поиска по базе данных (mySQL), или поисковых
                        движков Algolia и ElasticSearch.
                        <em>ElasticSearch сейчас отключен на сайте.</em>.
                    </p>
                </list-item>

                <list-item :show="show">
                    <a slot="href">Views Count and Trending</a>
                    <p>
                        Отслеживается количество просмотров каждого поста, на его основании
                        формируется TOP5 наиболее популярных постов (Trendng Vidget).
                    </p>
                </list-item>

                <list-item :show="show">
                    <a slot="href">Archives</a>
                    <p>
                        Архив позволяет просмотреть заметки за конкретный период времени (год:месяц).
                    </p>
                </list-item>

                <list-item :show="show">
                    <a slot="href">Tracking post changes</a>
                    <p>
                        Автор заметки имеет возможность просмотра истории всех ее изменений в формате
                        <code>user:date:field:before:after</code>.
                    </p>
                </list-item>

                <list-item :show="show">
                    <a slot="href">Comments</a>
                    <p>
                        Зарегистрированные пользователи имеют возможность коментировать заметки.
                        Пользователь может редактировать и удалять свои комментарии.
                    </p>
                </list-item>

                <list-item :show="show">
                    <a slot="href">Likes</a>
                    <p>
                        Зарегистрированные пользователи имеют возможность добавлять/убирать заметки
                        в/из избранные (favorites), фильтровать их.
                    </p>
                </list-item>

                <list-item :show="show">
                    <a slot="href">Notifications</a>
                    <p>
                        Пользователь информируется о значимых для него событиях (например новый
                        комментарий к его заметке). Сообщения отправляются по электронной почте,
                        могут быть просмотрены и удалены (отмечены как прочитанные) в личном
                        кабинете (профиле) пользователя.
                    </p>
                </list-item>

                <list-item :show="show">
                    <a slot="href">Social Media Integration (Facebook and Twutter)</a>
                    <p>
                        Пользователь может поделится (share) заметкой в собственнной ленте в социальных сетях.<br>
                        При создании новой заметки (Post) автоматически создаются записи (cross-posting) в ленте приложения в социальных сетях<br>
                        Поддерживаемые социальные сети:
                        <a href="https://twitter.com/MWazovzky">Twitter</a>,
                        <a href="https://www.facebook.com/M-LAB-Blog-140507703248558">Facebook</a>.
                    </p>
                </list-item>

                <list-item :show="show">
                    <a slot="href">External API</a>
                    <p>
                        Внешний API позвляет авторизованному пользователем приложению (Oauth2 протокол)
                        взаимодействовать с сайтом: получать, создавать, редактировать и удалять
                        заметки (посты) от имени пользователя и в соответствии с его полномочиями.
                        Подробное описание API находится на странице
                        <a href="{{ config('app.url') . '/developers' }}">разработчикам</a>.
                    </p>
                </list-item>

                <list-item :show="show">
                    <a slot="href">On-line Chat [-]</a>
                    <p>
                        On-line chat позволяет обмениваться короткими сообщениями с администратором и
                        другими пользователями находящимися на сервере.
                    </p>
                </list-item>
            </ul>
        </div>
    </list-group>

    <h4>Код проекта</h4>
    <p>
        Познакомиться с кодом проекта можно в <a href="https://github.com/mikewazovzky/monsterlab">репозитории</a> на Github.
    </p>
@endsection
