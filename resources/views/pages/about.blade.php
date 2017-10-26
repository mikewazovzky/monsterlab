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

    <list-group inline-template>
        <div>
            Основные компоненты проекта.
            <a href="#" @click.prevent="show = true">open all</a> /
            <a href="#" @click.prevent="show = false">close all</a>
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
                        например по тегам, году и месяцу создания.
                    </p>
                </list-item>

                <list-item :show="show">
                    <a slot="href">Search: database, Algolia, ElasticSearch</a>
                    <p>
                        Полнотекстовый поиск постов содержащих ключевые слова осуществляется
                        с использованием прямого поиска по базе данных (mySQL), или поисковых
                        движков Algolia и ElsaticSearch (сейчас отключен на сайте).
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
                        user:date:field:before:after.
                    </p>
                </list-item>

                <list-item :show="show">
                    <a slot="href">Replies</a>
                    <p>
                        Зарегистрированные пользователи имеют возможность коментировать заметки.
                    </p>
                </list-item>

                <list-item :show="show">
                    <a slot="href">Likes [-]</a>
                    <p>
                        Зарегистрированные пользователи имеют возможность отметить заметки и комментарии
                        как пнравившиеся (likes).
                    </p>
                </list-item>

                <list-item :show="show">
                    <a slot="href">Authorization System</a>
                    <p>
                        Система авторизации определяет полномочия пользователя по созданию и редактированию
                        контента в соответсвии с его ролью:  [guest, reader, writer, admin].
                    </p>
                </list-item>

                <list-item :show="show">
                    <a slot="href">Notifications</a>
                    <p>
                        Пользователь информируется о значимых для него событиях (например новый
                        комментарий к его заметке). Сообщения отправляются по электронной почте,
                        могут быть просмотрены и удалены (отмечены как прочитанные) в личном
                        кабинете (профиль пользователя) .
                    </p>
                </list-item>

                <list-item :show="show">
                    <a slot="href">External API [-]</a>
                    <p>
                        Внешний API позвляет авторизованному пользователем приложению получить доступ к
                        содержимому сайта.
                    </p>
                </list-item>

                <list-item :show="show">
                    <a slot="href">Integration with Social Media [-]</a>
                    <p>
                        Интеграция с социальными сетями позволяет пользователю поделится (share)
                        заметкой или автоматически дублировать (post) все созданные пользователем
                        заметки в социальных сетях.
                        Поддерживаемые социальные сети: Twitter, Facebook.
                    </p>
                </list-item>

            </ul>
        </div>
    </list-group>
@endsection
