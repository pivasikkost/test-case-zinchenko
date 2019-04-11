<?php

$paramsLocal = include __DIR__ . '/params-local.php';

$params = [
    'adminEmail' => 'admin@example.com',
];

return !empty($paramsLocal) ? array_merge($params, $paramsLocal) : $params;
