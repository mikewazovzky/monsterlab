<?php

function getValue($key, $model = null)
{
    return old($key) ?: (isset($model) ? $model->$key : null);
}
