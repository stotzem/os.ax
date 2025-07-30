<?php

require __DIR__ . '/../vendor/autoload.php';

$env = parse_ini_file(__DIR__ . '/../.env');

try {
    $db = new PDO(
        'mysql:host=' . $env['SQL_HOSTNAME'] . ';dbname=' . $env['SQL_DATABASE'],
        $env['SQL_USERNAME'], $env['SQL_PASSWORD'],
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4',
        ]
    );
} catch (PDOException $e) {
    die($e->getMessage());
}