<?php

$site = array(
    'title' => 'stotzem.dev',
    'main' => '',
);

$route = 'imprint';

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

    $stmt = $db->prepare("SELECT content FROM pages WHERE route = ? LIMIT 1");
    $stmt->execute([$route]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result !== false) {
        $site['main'] = $result['content'];
    }
    else {
        $site['main'] = 'not-found';
    }
} catch (PDOException $e) {
    die($e->getMessage());
}

ob_start();
require 'basetemplate.php';
ob_end_flush();