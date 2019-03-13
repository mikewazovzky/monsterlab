<h1>
    Тестрование  проекта Laravel/Vue [фронтенд] c помощью Mocha & Webpack
</h1>
<h2>
    Настройка среды тестирования. Пошаговая инструкция.
</h2>
<h3>
    платформа: MacOS, Windows 10
</h3>

<p>
    Приступим к разработке тестов фронтенда.
</p>

<p>
    Командой разработки Vue рекомендует два пакета для запуска тестов (test runner) 
    <a href="https://jestjs.io/docs/en/getting-started.html#content">Jest</a> и 
    <a href="https://github.com/zinserjan/mocha-webpack">mocha-webpack</a>.
    Воспользуемся вторым, который представляет собой обертку над mocha и webpack.
    Особенность такого подхода - предварительная компиляция кода с помощью webpack, 
    что позволяет использовать весь спектр возможностей webpack и vue-loader 
    в части поддержки однофайловых компонет Vue и конфигурирования webpack.    
</p>
<p>
    Описанный ниже подход немного отличается от обучающих материалов и статей
    которые гуглятся в интернете.
    Особенность - в разделении конфигурации для тестирования (test) от стандартной 
    конфигурации Laravel (laravel-mix) для development и production. 
    Собрать и сконфигурировать набор библиотек (и их версий) 
    на базе единой на все случаи конфигурации мне показалась нетривиальной задачей,
    а с учетом высокой динамики изменений - неблагодарной, обновление laravel-mix 
    приводит к необходимости решать ее с нуля.<br>
    Есть у такого подхода и свои минусы - догадайтесь сами какие...
</p>

<p>
    Шаг 1. Устанавливаем стандарный набор пакетов используемых в проекте, 
    собираем проект и забываем про него.  
</p>
<pre><code>
$ npm install
$ npm run dev
</code></pre>

<p>
    Шаг 2. Устаналиваем test runner и набор иинструментов для тестирования Vue.
</p>
<pre><code>
$ npm install --save-dev @vue/cli-plugin-babel @vue/cli-plugin-unit-mocha @vue/cli-service @vue/test-utils vue-template-compiler
</code></pre>

<p>
    Шаг 2. Устаналиваем пакеты для assertions и mocks. 
    Можно выбрать любые, мои предпочтения - chai и sinon. 
</p>
<pre><code>
$ npm install --save-dev chai sinon
</code></pre>

<p>
    Шаг 3. Конфигурируем babel.
</p>
<pre><code>
// babel.config.js

module.exports = {
    "env": {
        "test": {
            "presets": [
                ['@vue/app', {
                    polyfills: [
                        'es6.promise',
                        'es6.symbol',
                        'es6.module'
                    ]
                }]
            ]
        }
    }
};
</code></pre>

<p>
    Шаг 4. [не обязательно] Конфигурируем @vue/cli-service. Здесь можем внести изменения в конфигурацию webpack 
    и/или других пакетов используемых @vue/cli-service.
    В данном случае просто создаем alias "@" указывающий на папку resources/js в проекте Laravel. 
    Мне так удобнее.
</p>
<pre><code>
// vue.config.js

module.exports = {
    configureWebpack: {
        resolve: {
            alias: {
                "@": require("path").resolve(__dirname, "resources/js")
            }
        }
    }
}
</code></pre>

<p>
    Шаг 5. Создаем папку для размещения JS тестов. Можете назвать ее как угодно.
</p>
<pre><code>
$ mkdir tests/JavaScript
</code></pre>

<p>
    Шаг 6. Создаем в ней файл с конфигацией для тестов.
    Загружаем и делаем глобально доступными используемые пакеты.
</p>
<pre><code>
// tests/JavaScript/setup.js

global.expect = require('chai').expect
global.sinon = require('sinon')
global.axios = require('axios')
</code></pre>

<p>
    Шаг 6. Создаем в файле <code>package.json</code> скрипт для запуска тестов командой <code>npm tun test:unit</code>.
</p>
```json
// package.json

<pre><code>
// ...
"test:unit": "cross-env VUE_CLI_BABEL_TRANSPILE_MODULES=* vue-cli-service test:unit 'tests/JavaScript/**/*.spec.js'"
// ...
</code></pre>
<p>
    Комментарии:<br>
    <code>cross-env VUE_CLI_BABEL_TRANSPILE_MODULES=*</code> позволяет создавать mocks для ES6 модулей,<br>
    <code>--require tests/JavaScript/setup.js</code> указывает путь к созданному на преддущем шаге файлу конфигурации,<br>
    <code>'tests/JavaScript/**/*.spec.js'</code> запускает все тесты в файлах с расширением .spec.js и 
    находящиеся в папке tests/JavaScript и всех ее подпапках.
</p>

<p>
    Шаг 7. Создаем пример теста.
</p>
<pre><code>
// tests/JavaScript/test.spec.js

describe('Example test', () => {
    it('should test something', () => {
        expect(true).to.be.true
    })
})
</code></pre>

<p>
    ... запускаем его
</p>
<pre><code>
$ npm run test:unit
</code></pre>

<p>
    ... и видим такой результат:
</p>
<pre><code>
 MOCHA  Testing...
  Example test
    ✓ should test something
  1 passing (17ms)
 MOCHA  Tests completed successfully
</code></pre>

<h3>
    Не благодарите.
</h3>

<p>
    Проект с примерами тестов можно посмотреть 
    <a href="https://bitbucket.org/MWazovzky/bitbucket-ci-laravel/src/testing-mocha-webpack/">здесь</a>.
</p>

<h3>Полезные ссылки:</h3>
<a href="https://vue-test-utils.vuejs.org/guides/#getting-started">@vue-test-utils</a>, vue testing utility<br>
<a href="https://mochajs.org">Mocha</a>, tests runner<br>
<a href="https://www.chaijs.com">Chai</a>, assertions library<br>
<a href="https://sinonjs.org">Sinon</a>, mocks library<br>
