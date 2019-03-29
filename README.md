<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Test Project based on Yii 2</h1>
    <br>
</p>



REQUIREMENTS
------------

The minimum requirement by this project template that your Web server supports PHP 5.4.0.


INSTALLATION
------------

### Clone repository

First you need to clone the repository of this project:

~~~
git clone https://github.com/pivasikkost/test-case-zinchenko <target folder>
~~~

### Install via Composer

If you do not have [Composer](http://getcomposer.org/), you may install it by following the instructions
at [getcomposer.org](http://getcomposer.org/doc/00-intro.md#installation-nix).

Some project files are not contained in the repository, to install them, go to the project directory and execute the command:

~~~
php composer.phar install
~~~


CONFIGURATION
-------------

### Database

Then you need to copy the `config/db_default.php` file to `config/db.php` and specify the actual database access for your server, fox example:

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=yii2basic',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',
];
```

### Migration

Then you need to create a database for this project and fill it with migrations. You will need to go to the project directory and execute the command:
```
php yii migrate
```

### Verifying the installation

After the done actions you need only to configure the web server and go to url
```
/index.php?r=orders
```

