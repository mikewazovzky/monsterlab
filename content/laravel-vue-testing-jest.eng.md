<h1>Laravel/Vue project frontend testing with Jest</h1>
<h2>Configuration instruction</h2>
<h3>developer platform: MacOS</h3>

<p>
    Install default laravel packages
</p>
<pre><code>
$ npm install
</code></pre>

<p>
    Install @vue/test-utils
</p>
<pre><code>
$ npm install -—save-dev @vue/test-utils vue-template-compiler
</code></pre>

<p>
    Install test runner and related tools
</p>
<pre><code>
$ npm install -—save-dev jest vue-jest
</code></pre>

<p>
    Install and configure babel
</p>
<pre><code>
$ npm install -—save-dev babel-core babel-preset-env babel-plugin-syntax-object-rest-spread
</code></pre>

<pre><code>
// .babelrc

{
    "env": {
        "test": {
            "presets": [
                [
                    "env",
                    {
                        "targets": {
                            "node": "current"
                        }
                    }
                ]
            ],
            "plugins": ["syntax-object-rest-spread"]
        }
    }
}
</code></pre>

<p>
    Create jest config file
</p>
<pre><code>
// jest.config.js

module.exports = {
    "moduleFileExtensions": [
        "js",
        "vue"
    ],
    "moduleNameMapper": {
        "^@/(.*)$": "<rootDir>/resources/js/$1"
    },
    "transform": {
        "^.+\\.js$": "<rootDir>/node_modules/babel-jest",
        ".*\\.(vue)$": "<rootDir>/node_modules/vue-jest"
    }
}
</code></pre>

<p>
    Create examples test
</p>
<pre><code>
// tests/JavaScript/example.spec.js

describe('Example test', () => {
    it('should test something', () => {
        expect(true).toBe(true)
    })
})
</code></pre>

<p>
    ... run it
</p>
<pre><code>
$ npm test
</code></pre>

<p>
    ... and see the results:
</p>
<pre><code>
> jest

 PASS  tests/JavaScript/example.spec.js
  Example test
    ✓ should test something (3ms)

Test Suites: 1 passed, 1 total
Tests:       1 passed, 1 total
Snapshots:   0 total
Time:        1.634s
Ran all test suites.
</code></pre>

<h3>
    Congrats!
</h3>

<p>
    Example project with tests
    <a href="https://bitbucket.org/MWazovzky/bitbucket-ci-laravel/src/testing-jest/">here</a>
</p>

<h3>
    Usefull links
</h3>

<a href="https://vue-test-utils.vuejs.org/guides/#getting-started">@vue-test-utils</a>, vue testing utility<br>
<a href="https://jestjs.io/docs/en/getting-started.html">Jest</a>, testing library<br>
