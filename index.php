<?php

define('LANGUAGES_PATH', __DIR__ . '/locale');

$locale = $_GET['lang'] ?? 'en_US';

putenv('LC_ALL=' . $locale);

setlocale(LC_ALL, $locale, $locale . '.utf8');

bind_textdomain_codeset($locale, 'UTF-8');

bindtextdomain($locale, LANGUAGES_PATH);

textdomain($locale);

include __DIR__ . '/monsterlab.php';