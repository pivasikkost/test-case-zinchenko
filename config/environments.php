<?php

// comment out the following two lines when deployed to production
//defined('YII_DEBUG') or define('YII_DEBUG', true);
//defined('YII_ENV') or define('YII_ENV', 'dev');


$environmentsLocalPath = __DIR__ . '/environments-local.php';
if (file_exists($environmentsLocalPath)) {
    include $environmentsLocalPath;
}
