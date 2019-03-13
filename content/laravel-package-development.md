# Laravel Package Development
## Folder structure
./laravel-packages/laravel/5.5.x
                  /laravel/5.6.x
                  /laravel/5.7.x
                  /...
                  /packages/MWazovzky/Adjustable
                  /packages/MWazovzky/Taggable
                  /...

## Install Laravel 
composer create-project --prefer-dist laravel/laravel/5.7.x 5.7.x

## Create sym link for pakages folder
mklink /d "C:\Users\Dev\OSPanel\domains\laravel-packages\laravel\5.4.x\packages" "C:\Users\Dev\OSPanel\domains\laravel-packages\packages"
mklink /d "C:\Users\Dev\OSPanel\domains\laravel-packages\laravel\5.5.x\packages" "C:\Users\Dev\OSPanel\domains\laravel-packages\packages"
mklink /d "C:\Users\Dev\OSPanel\domains\laravel-packages\laravel\5.6.x\packages" "C:\Users\Dev\OSPanel\domains\laravel-packages\packages"
mklink /d "C:\Users\Dev\OSPanel\domains\laravel-packages\laravel\5.7.x\packages" "C:\Users\Dev\OSPanel\domains\laravel-packages\packages"

## Instruct composer to load package classes
``` json
// composer.json

"psr-4": {
    "App\\": "app/",
    "MWazovzky\\Adjustable\\": "packages/MWazovzky/Adjustable/src/"
}
```

## Register package service provider
```php
// config/app.php

/*
 * Package Service Providers...
 */
MWazovzky\Adjustable\AdjustableServiceProvider::class,
```

## Testing
```
cd C:/Users/Dev/OSPanel/domains/laravel-packages/packages/MWazovzky/Adjustable/src
../../../../laravel/5.4.x/vendor/bin/phpunit
```
