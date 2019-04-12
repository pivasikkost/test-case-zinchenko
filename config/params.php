<?php

$paramsLocalPath = __DIR__ . '/params-local.php';;
$paramsLocal = file_exists($paramsLocalPath) ? include $paramsLocalPath : array();

$params = [
    'adminEmail' => 'admin@example.com',
];

return !empty($paramsLocal) ? array_merge($params, $paramsLocal) : $params;
