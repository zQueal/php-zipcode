About
==============

A simple configuration script to pull `city`, `state`, and `country` from a given zipcode. This is more of a proof of concept that even though this is now 2014 we're still requiring people to put in their full addresses when its totally unnecessary. The included class and concept can be used with webstores and the like to ensure that checking out for your customers is as simple as possible. The only requirements would be a PO BOX or street address and zipcode.

####Index
* [Namespace](#namespace)
* [About Phalcon](#about-phalcon)
  * [Built In Webserver](#built-in-webserver)
  * [Apache](#apache)
  * [Nginx](#nginx)
* [Classes](#classes)
  * [ZipCode](#zipcode)
* [Pull Requests and Support](#pulls-and-support)

Namespace
==============

Ensure you have at least PHP version `5.3.0` to be able to work with namespaces. The two that are used in this project are `Phalcon` and `Curl`.

```php
include 'Network/Curl/Curl.php';

use Phalcon\Mvc\Micro as Micro;
use Network\Curl\Curl as Curl;
```

Phalcon is a super fast C extension for PHP and is very easy to install and use. This example uses the Micro application class. `Network\Curl\Curl` is a very simplistic [cURL library](https://github.com/Xanza/curl-php) for creating simple cURL calls.

About Phalcon
==============

To be able to use phalcon it must be installed as a PHP extension and you must use the correct routing method for your preferred setup.

------------------------
####Built In Webserver

The built in webserver that we all have access to with the newer versions of PHP works just fine with the micro application functions included with Phalcon. However, to access them you must create another PHP file `.htrouter.php` and include it with your `index.php`.

```php
<?php

if(!file_exists(__DIR__ . '/' . $_SERVER['REQUEST_URI'])){
    $_GET['_url'] = $_SERVER['REQUEST_URI'];
}

return false;
```

Once you've done that, it will route just fine.

------------------------
####Nginx

An example nginx `server{ }` function would look something like this:

```php
server {

    listen   80;
    server_name localhost.dev;

    index index.php index.html index.htm;
    set $root_path '/var/www/phalcon/public';
    root $root_path;

    try_files $uri $uri/ @rewrite;

    location @rewrite {
        rewrite ^/(.*)$ /index.php?_url=/$1;
    }

    location ~ \.php {
        fastcgi_pass unix:/run/php-fpm/php-fpm.sock;
        fastcgi_index /index.php;

        include /etc/nginx/fastcgi_params;

        fastcgi_split_path_info       ^(.+\.php)(/.+)$;
        fastcgi_param PATH_INFO       $fastcgi_path_info;
        fastcgi_param PATH_TRANSLATED $document_root$fastcgi_path_info;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }

    location ~* ^/(css|img|js|flv|swf|download)/(.+)$ {
        root $root_path;
    }

    location ~ /\.ht {
        deny all;
    }
}
```

------------------------
####Apache

Apache must simply have `AllowOverride All` enabled for your project directory, and include a `.htaccess` file with the following contents:

```php
    RewriteEngine On
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^(.*)$ index.php?_url=/$1 [QSA,L]
```

Classes
==============

There is only a single class in this example: `ZipCode`. It's a static method which is used to execute the cURL request and dump the results into an object (`$d`) and retuns the value.

--------------
####ZipCode

This static method class is used to facilitate the return of the different types of data that we can access, including `city`, `state`, and `country`. Each return has their own static function along with a static function for `all` which will return all three data values.


Pulls and Support
==================
I do not actively maintain this repository. If you have an improvement I'm open to pull requests, but I do not offer support.
