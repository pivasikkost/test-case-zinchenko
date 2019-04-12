<?php

$dbLocalPath = __DIR__ . '/db-local.php';
$dbLocal = file_exists($dbLocalPath) ? include $dbLocalPath : array();

$db = [
    'class' => '<db-connection-class>',
    'dsn' => '<data-source-name>',
    'username' => '<username>',
    'password' => '<user-password>',
    'charset' => '<charset>',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];

return !empty($dbLocal) ? array_merge($db, $dbLocal) : $db;
