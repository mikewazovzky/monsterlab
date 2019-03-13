<h1>
    Travis CI: Secure Environment Variables
</h1>
<h3>Шифрование переменных среды в проектах с использованием<br />Travis CI Continuous Integration</h3>
<p>При автоматическом тестировании с помощью Travis CI приложений обращающихся к внешним
сервисам может возникнуть необходимость указания конфиденциальных данных
пользователя (аккаунт, пароль, ...) необходимых для доступа к этим сервисам.
Обычно такие данные хранятся в переменных среды в файле конфгурации проекта (например <code>.env</code>)
и не включаются в репозиторий проекта.</p>
<p>Конечно можно включить все необходимые параметры в репозиторий,
но с этого момента они перестанут быть конфиденциальными.
Решение этой проблемы - создание зашифрованных переменных.</p>
<p>Travis CI позволяет генерировать пару RSA ключей (приватный и публичный), используемых для шифрования информации,
которая может быть размещена в файле <code>.travis.yml</code> и при этом остаться конфиденциальной.</p>
<p>Процесс создания зашифрованных переменных выглядит следующим образом</p>

<ol><li>
<p>Установить <a href="http://www.ruby-lang.org/en/">Ruby</a>. Убедиться, что все получилось</p>
<pre><code>
$ ruby -v
ruby 2.4.2p198 (2017-09-14 revision 59899) [x64-mingw32]
</code></pre>
</li>
<li>
<p>Установить Travis CI CLI</p>
<pre><code>
$ gem install travis -v 1.8.8 --no-rdoc --no-ri
$ travis version
1.8.8
</code></pre>
</li>
<li>
<p>Теперь мы можем создать зашифрованные переменные</p>
<pre><code>
$ travis encrypt SOMEVAR="secretvalue"
</code></pre>
</li>
<li>
<p>и добавить их в файл конфигурации с ключом <code>secure</code></p>
<p>Можно автоматически добавлять переменные при создании используя флаг <code>--add</code>.</p>
<pre><code>
$ travis encrypt SOMEVAR="secretvalue" --add
</code></pre>
<p>В результате каждой переменной вида key => value будет соответсвовать строка
символов в файле <code>.travis.yml</code> которая будут выглядеть примерно так
 </p>
<pre><code>
# Файл .travis.yml
env:
  global:
  - secure: kwM/LytpXrLtGJruAtBtCI5IDzw0SSKPVYOOIS4LOkS44XqB+q8+gdQ=
  - secure: ZH6NiI4DsSyuh51G9Hq+bqqBT0cJEQyZ4pX1grFhRxeJEgLbx8t8jSf=
</code></pre>
</li>
</ol><p>Осталось загрузить файл конфигурации в проект, запустить сборку проекта и убедиться,
что все работает.</p>
<p>Документация: <a href="https://docs.travis-ci.com/user/encryption-keys">Travis CI Encryption keys</a></p>
