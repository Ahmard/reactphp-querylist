# ReactPHP QueryList

This library brought [ReactPHP](https://github.com/reactphp/http) and [QueryList](https://github.com/jae-jae/QueryList)
together.

## Installation

```
composer require ahmard/reactphp-querylist
```

## Usage

- Playing with **QueryList**(scraping)
```php
use ReactphpQuerylist\Client;
use ReactphpQuerylist\Queryable;

require 'vendor/autoload.php';

Client::get('https://google.com')
    ->then(function (Queryable $queryable){
        $title = $queryable->queryList()->find('head title')->text();
        var_dump($title);
    })
    ->otherwise(function ($error){
        echo $error;
    });
```

- Working with response object
```php
use ReactphpQuerylist\Client;
use ReactphpQuerylist\Queryable;

require 'vendor/autoload.php';

Client::get('https://google.com')
    ->then(function (Queryable $queryable){
        var_dump($queryable->response()->getReasonPhrase());
    })
    ->otherwise(function ($error){
        echo $error;
    });
```