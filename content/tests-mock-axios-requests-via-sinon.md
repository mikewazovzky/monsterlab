<h1>
    Эмуляция запросов к серверу (axios) при написании юнит тестов с помощью Sinon.js
</h1>
<h4>Stub unit test axios calls with Sinon</h4>
<p>
В последнее время для эмуляции и тестирования AJAX запросов вообще и запросов с
использованием библиотеки <a href="https://github.com/axios/axios">axios</a> в
частности появилось множество специализированных сервисов,
например <a href="https://httpbin.org/">httpbin</a>,
и разной степени специализированности библиотек, например
<a href="https://github.com/testdouble/testdouble.js/">testdouble.js</a>,
<a href="https://github.com/ctimmerm/axios-mock-adapter">axios-mock-adapter</a> и
даже разработанная создателем axios
<a href="https://github.com/axios/moxios">moxios</a>.
</p>
<p>
После некторых размышлений при тестировании моего проекта я решил использовать старый добрый
<a href="http://sinonjs.org/">sinon.js</a>.
Основные аргументы: консистентный подход к тестированию в проекте, отсутствие необходимости загружать
еще одну библиотеку и привыкать к ее api.
</p>
<p>
Для решения моей задачи Sinon предлагает два (как минимум) возможных подхода:
</p>
<ol><li>Создание Fake Server (<a href="http://sinonjs.org/releases/v4.4.2/fake-xhr-and-server/">ссылка</a>) и</li>
<li>Создание тестовых дублей (test double) для запросов к серверу, соответстующих методам объекта (axios в нашем случае).</li>
</ol><p>
Вторая альтернатива показалась мне более привычной и я решил остановиться на ней.
Вот, что из этого получилось. Сами тесты:
</p>
<pre><code>
// tests/test.spec.js
import axios from 'axios'
import sinon from 'sinon'
import axiosStub from './helpers/api'

// Method to be tested
const post = (url, payload) => {
    return axios.post(url, payload)
}

describe('axios', () => {
    beforeEach(() => axiosStub.create())
    afterEach(() => axiosStub.restore())

    let url = '/tasks';
    let payload = { body: 'New task' }

    it('posts with valid url, valid payload', (done) => {
        post(url, payload).then(response => {
            expect(response.status).to.equal(200)
            expect(response.data).to.deep.equal({ id: 5, body: 'New task' })
            done()
        })
    })

    it('posts with invalid url', (done) => {
        let url = '/abc';

        post(url, payload).catch(response => {
            expect(response.status).to.equal(404)
            expect(response.error.message).to.equal('Page not found')
            done()
        })
    })

    it('posts with valid url, invalid payload (backend validation error)', (done) => {
        let payload = { body: null }

        post(url, null).catch(response => {
            expect(response.status).to.equal(422)
            expect(response.error.message).to.equal('Unprocessable entity')
            done()
        })
    })
})
</code></pre>

<p>
Используемая для эмуляции метода <code>axios.post</code> заглушка (stub) axiosStub опредеяется в файле <code>api.js</code>,
создается в методе beforeEach(): <code>axiosStub.create()</code>,
и уничтожается в методе afterEach(): <code>axiosStub.restore()</code>.
</p>
<p>
<code>axiosStub</code> анализирует параметры запроса к серверу, определяет верный вариант ответа и возвращает его.
</p>
<pre><code>
// tests/helpers/api.js
import axios from 'axios'
import sinon from 'sinon'

let stub;

// Define possible server responses
const response = {
    status: 200,
    data: { id: 5, body: 'New task' }
}

const error404 = {
    status: 404,
    error: { message: 'Page not found' }
}

const error422 = {
    status: 422,
    error: { message: 'Unprocessable entity' }
}

// Create a stub and define proper server response depending on axios.post parameters
const create = () => {
    stub = sinon.stub(axios, 'post')

    // Option 1: valid url, valid payload
    // as of sinon@2.0.0 it returns a Promise that resolves to specified value
    stub.withArgs('/tasks', { body: 'New task' }).resolves(response)

    // Option 2: invalid url
    stub.withArgs('/abc', { body: 'New task' }).returns(new Promise((resolve, reject) => reject(error404)))

    // Option 3: invalid payload (server side validation error)
    stub.withArgs('/tasks', null).returns(new Promise((resolve, reject) => reject(error422)))
    stub.withArgs('/tasks', {}).returns(new Promise((resolve, reject) => reject(error422)))
    stub.withArgs('/tasks', { body: null }).returns(new Promise((resolve, reject) => reject(error422)))
}

// Destroy stub and restore original axios.post
const restore = () => {
    stub.restore()
}

export default {
    create,
    restore
}

</code></pre>

<p>
В принципе получивший код работоспособен, запросы к серверу перехватываюся, все тесты успешно выполняются,
но есть небольшая проблема.
</p>
<p>
При каждом обращении к <code>axiosStub.create()</code>
создается полный набор ответов на всевозможные запросы, которые являются выполненными (resolved/rejected) <code>Promise</code>.
Те <code>Promise</code> (rejected), которые не были непосредственно перехвачены и обработаны в тестах "беспокоят" <code>node</code>,
о чем он любезно нам сообщает. В результате отчет о выполнении тестов выглядит не совсем так, как я ожидал:
</p>
<pre><code>
  axios
    √ posts with valid url, valid payload
(node:20596) UnhandledPromiseRejectionWarning: Unhandled promise rejection (rejection id: 1): #<Object>
(node:20596) UnhandledPromiseRejectionWarning: Unhandled promise rejection (rejection id: 2): #<Object>
(node:20596) UnhandledPromiseRejectionWarning: Unhandled promise rejection (rejection id: 3): #<Object>
(node:20596) UnhandledPromiseRejectionWarning: Unhandled promise rejection (rejection id: 4): #<Object>
    √ posts with invalid url, valid payload
(node:20596) UnhandledPromiseRejectionWarning: Unhandled promise rejection (rejection id: 6): #<Object>
(node:20596) UnhandledPromiseRejectionWarning: Unhandled promise rejection (rejection id: 7): #<Object>
(node:20596) UnhandledPromiseRejectionWarning: Unhandled promise rejection (rejection id: 8): #<Object>
    √ posts with valid url, invalid payload (no payload)
(node:20596) UnhandledPromiseRejectionWarning: Unhandled promise rejection (rejection id: 9): #<Object>
(node:20596) UnhandledPromiseRejectionWarning: Unhandled promise rejection (rejection id: 11): #<Object>
(node:20596) UnhandledPromiseRejectionWarning: Unhandled promise rejection (rejection id: 12): #<Object>
</code></pre>
<p>
Можно представить, как будет выглядеть результа тестирования полноценного api.
</p>
<p>
Решить эту проблему, а заодно получить намного большую гибкость за счет
возможности конструировать ответ сервера динамически на основании параметров <code>axios</code>
запроса, можно при создании эмулятора с помощью метода <code>callsFake()</code>.
</p>
<pre><code>
let stub = sinon.stub(axios, 'post').callsFake(fakeFn)
</code></pre>
<p>
Метод <code>callsFake(fakeFn)</code> при каждом обращении к <code>axiosStub</code> вызывает
функцию <code>fakeFn(arg1, arg2, ...)</code> передает ей параметры запроса, получает результат ее
выполнения и возвращает его в качестве своего результата.
</p>
<p>
Собственно это все о чем можно было мечтать.
</p>
<p>
Для тестирования любого API достаточно прописать возможныe вырианты ответов сервера и модифицировать
функцию fakeFn() выбирающую, какой из них вернуть.
</p>
<p>
Задача решена, sinon rulez.
</p>
<p>
Окончательная версия кода.
</p>
<pre><code>
import axios from 'axios'
import sinon from 'sinon'

let stub;

// Define possible server responses
const response = {
    status: 200,
    data: { id: 5, body: 'New task' }
}

const error404 = {
    status: 404,
    error: { message: 'Page not found' }
}

const error422 = {
    status: 422,
    error: { message: 'Unprocessable entity' }
}

// Create a stub
const create = () => {
    stub = sinon.stub(axios, 'post').callsFake(fakeFn)
}

// Destroy stub and restore original axios.post
const restore = () => {
    stub.restore()
}

// Define proper server response depending on axios.post parameters
const fakeFn = (endpoint, payload) => {
    if (endpoint !== '/tasks') {
        return new Promise((resolve, reject) => reject(error404))
    }

    if (!payload || !payload.body) {
        return new Promise((resolve, reject) => reject(error422))
    }

    return new Promise((resolve) => resolve(response))
}

export default {
    create,
    restore
}
</code></pre>
