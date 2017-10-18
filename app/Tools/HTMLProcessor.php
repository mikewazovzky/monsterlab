<?php

namespace App\Tools;

use HTMLPurifier;
use HTMLPurifier_Config;

class HTMLProcessor
{
    protected $purifier;

    /**
     * Create HTMLProcessor instance.
     */
    public function __construct()
    {
        $config = HTMLPurifier_Config::createDefault();
        // $config->set('param.name', $param);

        $this->purifier = new HTMLPurifier($config);
    }

    /**
     * Process html content.
     * Purify content.
     * Replace <pre><code> tags before purification to evoid code samples processing
     *
     * @problem there is a [theoretical] problem with nested <pre><code> tags if any
     * @param string $data
     * @return string
     */
    public function process($data)
    {
        // Strip off <![CDATA[..]]> tags if already exists
        $content = str_replace(
            array('<![CDATA[', ']]>'),
            array('', ''),
            $data
        );

        $content = str_replace(
            array('<pre><code>', '</code></pre>'),
            array('<pre><code><![CDATA[', ']]></code></pre>'),
            $content
        );

        return $this->purifier->purify($content);
    }
}
