<h1>
    Laravel/Vue project frontend testing with Mocha && Webpack
</h1>
<h2>
    Configuration instruction
</h2>
<h3>
    developer platform: MacOS, Windows 10
</h3>

<p>
    Install default laravel packages
</p>
<pre><code>
$ npm install
</code></pre>

<p>
    Install vue testing tools
</p>
<pre><code>
$ npm install --save-dev @vue/cli-plugin-babel @vue/cli-plugin-unit-mocha @vue/cli-service @vue/test-utils vue-template-compiler
</code></pre>

<p>
    Install test libraries
</p>
<pre><code>
$ npm install --save-dev chai sinon
</code></pre>

<p>
    Create babel config
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
    Create @vue/cli-service config
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
    Create tests folder, you may call it whatever you like
</p>
<pre><code>
$ mkdir tests/JavaScript
</code></pre>

<p>
    Create tests config
</p>
<pre><code>
// tests/JavaScript/setup.js

global.axios = require('axios')
global.expect = require('chai').expect
global.sinon = require('sinon')
</code></pre>

<p>
    Add `npm test` script to `package.json` file
</p>
```json
// package.json

<pre><code>
// ...
"test:unit": "cross-env VUE_CLI_BABEL_TRANSPILE_MODULES=* vue-cli-service test:unit --require tests/JavaScript/setup.js 'tests/JavaScript/**/*.spec.js'"
// ...
</code></pre>

<p>
    Create example test
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
    ... run it
</p>
<pre><code>
$ npm run test:unit
</code></pre>

<p>
    ... and see the results:
</p>
<pre><code>
 MOCHA  Testing...
  Example test
    ✓ should test something
  1 passing (17ms)
 MOCHA  Tests completed successfully
</code></pre>

<h3>
    Congrats!
</h3>

<p>
    Example project with tests
    <a href="https://bitbucket.org/MWazovzky/bitbucket-ci-laravel/src/testing-mocha-webpack/">here</a>
</p>

<h3>Usefull links</h3>
<a href="https://vue-test-utils.vuejs.org/guides/#getting-started">@vue-test-utils</a>, vue testing utility<br>
<a href="https://mochajs.org">Mocha</a>, tests runner<br>
<a href="https://www.chaijs.com">Chai</a>, assertions library<br>
<a href="https://sinonjs.org">Sinon</a>, mocks library<br>
