<h1>
    Laravel/Vue project frontend testing with Mocha && Webpack, Part II Code Coverage
</h1>
<h2>
    Code coverage analyses with Istanbul 
</h2>

<p>
    Let's add some nice looking code coverage reporting. Configuring it happened to be more difficult then I expcted. But ... we can google it!
</p>

Install <code>istanbul</code>, related loader <code>istanbul-instrumenter-loader</code> and  babel plugin <code>babel-plugin-istanbul</code><br>
I also installed <code>path</code>, just for convinience.
<pre><code>
npm install --save-dev nyc istanbul-instrumenter-loader babel-plugin-istanbul path
</code></pre>

Add plugin to <code>babel.config.js</code>
<pre><code>
// babel.config.json

module.exports = {
    // ...
    "plugins": ["babel-plugin-istanbul"]
    // ...
};
</code></pre>

Configure webpack to use istanbul loader
<pre><code>
// vue.config.js

const path = require('path')

module.exports = {
    // ...
    chainWebpack: config => {
        if (process.env.NODE_ENV !== "production") {
            config.devtool('eval')
            config.module
                .rule("istanbul")
                .test(/\.(js|vue)$/)
                .enforce("post")
                .include.add(path.resolve(__dirname, '/resorces/js'))
                .end()
                .use("istanbul-instrumenter-loader")
                .loader("istanbul-instrumenter-loader")
                .options({ esModules: true })
                .end();
        }
    }
}
</code></pre>

Make Vue available globally to tests via <code>setup.js</code>
<pre><code>
// tests/JavaScript/setup.js

// ...
global.Vue = require('vue')
// ...
</code></pre>

Update <code>package.json</code>:
modify <code>test:unit</code> command to have <code>.vue</code> files (SFC) analysed for test coverage
create <code>cover</code> command to run tests and create test coverage report
<pre><code>
// package.json

// ...
"test:unit": "cross-env VUE_CLI_BABEL_TRANSPILE_MODULES=* vue-cli-service test:unit --require tests/JavaScript/setup.js 'resources/js/**/*.{js,vue}' 'tests/JavaScript/**/*.spec.js'",
"cover": "nyc npm run test:unit"
//...
</code></pre>

Create istanbul configuration file <code>.nycrc</code>
<pre><code>
// .nycrc

{
    "check-coverage": false,
    "per-file": true,
    "include": [
        "resources/js/**/*.{js,vue}"
    ],
    "reporter": [
        "lcov",
        "text",
        "text-summary"
    ],
    "cache": true,
    "all": true,
    "temp-dir": "./tests/coverage/js/tmp",
    "report-dir": "./tests/coverage/js"
}
</code></pre>

Instruct git to ignore coverage reporting
<pre><code>
# .gitignore

# ...
/tests/coverage
# ...
</code></pre>

Run 
<pre><code>
npm run cover
</code></pre>

... and get nice looking coverage report
<pre><code>
 MOCHA  Tests completed successfully

-----------------------|----------|----------|----------|----------|-------------------|
File                   |  % Stmts | % Branch |  % Funcs |  % Lines | Uncovered Line #s |
-----------------------|----------|----------|----------|----------|-------------------|
All files              |       60 |    57.14 |    33.33 |    60.32 |                   |
 js                    |    94.12 |       50 |      100 |    94.12 |                   |
  app.js               |      100 |      100 |      100 |      100 |                   |
  bootstrap.js         |    90.91 |       50 |      100 |    90.91 |                36 |
 js/api                |      100 |      100 |      100 |      100 |                   |
  index.js             |        0 |        0 |        0 |        0 |                   |
  user.js              |      100 |      100 |      100 |      100 |                   |
 js/components         |    28.57 |      100 |    28.57 |    28.57 |                   |
  Counter.vue          |      100 |      100 |      100 |      100 |                   |
  CounterGlobal.vue    |        0 |      100 |        0 |        0 |       25,35,36,37 |
  ExampleComponent.vue |        0 |      100 |        0 |        0 |                20 |
  User.vue             |        0 |      100 |        0 |        0 |       13,18,19,20 |
  UserGlobal.vue       |    66.67 |      100 |    66.67 |    66.67 |                20 |
 js/components/Tests   |        0 |        0 |        0 |        0 |                   |
  Test.vue             |        0 |        0 |        0 |        0 |                   |
 js/store              |      100 |      100 |      100 |      100 |                   |
  index.js             |      100 |      100 |      100 |      100 |                   |
 js/store/modules      |    48.28 |       60 |    33.33 |    48.15 |                   |
  counter.js           |    21.05 |        0 |        0 |    22.22 |... 30,31,33,34,35 |
  user.js              |      100 |      100 |      100 |      100 |                   |
-----------------------|----------|----------|----------|----------|-------------------|

=============================== Coverage summary ===============================
Statements   : 60% ( 39/65 )
Branches     : 57.14% ( 4/7 )
Functions    : 33.33% ( 9/27 )
Lines        : 60.32% ( 38/63 )
================================================================================
</code></pre>

<h3>Usefull links</h3>
<a href="https://github.com/istanbuljs/nyc">Istanbul</a>, code coverage report generator
