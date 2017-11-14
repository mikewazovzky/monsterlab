<?php

/**
 * Flash message to the session
 *
 * @param string|null $title
 * @param string|null $message
 * @return App\Tools\Flash
 */
function flash($message = null)
{
    $flash = app('App\Tools\Flash');

    if (func_num_args() == 0) {
        return $flash;
    }

    return $flash->success($message);
}

function getValue($key, $model = null)
{
    return old($key) ?: (isset($model) ? $model->$key : null);
}

function highlight(string $search, string $subject)
{
    $replace = "<span class=\"hightlight\">{$search}</span>";

    return str_replace($search, $replace, $subject);
}
