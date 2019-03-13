<h1>
    HTML Purification
</h1>
<h3>Очистка контента предоставленного клиентом от опасного и вредоностного кода</h3>
<p>
Задача очистки клиентского контента, актуальная для многих веб приложений, имеет простое и
быстрое решение - <a href="http://htmlpurifier.org/">HTML Purifier</a>.
</p>
<p>
Несмотря на обилие возможностей по конфигурации (о наиболее интересных и полезных
напишу позже), со своей основной задачей - очисткой HTML контента от опасного и
вредоностного кода - пакет отлично справляется в своей стандартной конфигурации.
</p>
<h4>Пример использования пакета</h4>
<ol><li>
<p>Устанавливаем пакет. Мне привычнее использовать composer</p>
<pre><code>
$ composer require ezyang/htmlpurifier
</code></pre>
</li>
<li>
<p>Указывем путь к автозагрузчику пакета в файле composer.json</p>
<pre><code>
"autoload": {
    "classmap": [
        "database"
    ],
    "files": [
        "vendor/ezyang/htmlpurifier/library/HTMLPurifier.auto.php"
    ],
    "psr-4": {
        "App\\": "app/"
    }
}
</code></pre>
</li>
<li>
<p>HTML Purifier готов к использованию в приложении. Пример из документации:</p>
<pre><code>
$config = HTMLPurifier_Config::createDefault();<br>
$purifier = new HTMLPurifier($config);<br>
$clean_html = $purifier->purify($dirty_html);<br>
</code></pre>
</li>
<li>
<p>Пример использования в проекте Laravel. Контент автоматически очищается при передаче данных модели.</p>
<pre><code>
namespace App;

use HTMLPurifier;
use HTMLPurifier_Config;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function setContentAttribute($value)
    {
        $config = HTMLPurifier_Config::createDefault();
        $purifier = new HTMLPurifier($config);
        $this->attributes['content']  = $purifier->purify($value);
    }
}
</code></pre>
</li>
</ol>
