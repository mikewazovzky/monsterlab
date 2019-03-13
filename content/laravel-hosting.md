<h1>
    Краткая инструкция по деплою проекта Laravel на внешний хостинг
</h1>
<p>
Начнем с конца :).<br />
Ниже приведена достаточно подробная пошаговая инструкция по загрузке завершенного проекта на
сайт хостинг провайдера на примере <a href="https://beget.com">beget.com</a>.<br /></p>
<ol><li>
<p>Загрузить в корневой каталог проекта <code>projectname</code> папку с файлами проекта <code>projectname/project</code></p>
<pre><code>
$ cd projectname<br>
$ git clone https://github/username/projectname project
</code></pre>
</li>
<li>
<p>Создать в корневом каталоге проекта <code>projectname</code> сим-линк <code>public_html</code> на директорию <code>project/public</code> проекта</p>
<pre><code>
$ ln -s /home/a/username/projectname/project/public public_html
</code></pre>
</li>
<li>
<p>Установить локально (в проект) composer</p>
<pre><code>
$ cd project<br>
$ curl -sS https://getcomposer.org/installer | php
</code></pre>
</li>
<li>
<p>Установить зависимости проекта (команда phpX.X соответсвует версии PHP)</p>
<pre><code>
$ php7.1 composer.phar install
</code></pre>
</li>
<li>
<p>Установить права доступа (разрешить запись файлов) на каталог <code>project/storage</code></p><p>
</p><pre><code>
$ chmod -R o+w storage
</code></pre>
</li>
<li>
<p>Создать в папке <code>public</code> сим-линк <code>public/storage</code> на папку <code>project/storage/app/public</code></p>
<pre><code>
$ ln -s /home/a/username/projectname/project/storage/app/public public/storage
</code></pre>
</li>
<li>
<p>Создать базу данных проекта</p>
</li>
<li>
<p>Внести параметры базы данных (имя базы данных, имя пользователя и пароль) и другие параметры приложения для production environment в файл <code>.env</code></p>
</li>
<li>
<p>Скопировать файл <code>.env</code> в корень проекта</p>
</li>
<li>
<p>Выполнить миграцию баз данных</p>
<pre><code>
$ php artisan migrate
</code></pre>
</li>
</ol><p>Зайти на сайт в качестве клиента и убедиться, что все работает.</p>
<br /><h4>Для внесения изменений на сайт нужно</h4>
<ol><li>
<p>Загрузить обновления кода</p>
<pre><code>
$ git pull
</code></pre>
</li>
<li>
<p>Обновить зависимости, если в проект были добавлены новые пакеты</p>
<pre><code>
$ php7.1 composer.phar update
</code></pre>
</li>
<li>
<p>Обновить структуру базы данных, если она менялась.</p>
<pre><code>
$ php artisan migrate
</code></pre>
</li>

</ol><p>Службе поддержки <a href="https://beget.com">beget.com</a> спасибо за оперативные и толковые ответы на возникающие вопросы.</p>
