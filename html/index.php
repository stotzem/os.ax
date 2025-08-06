<?php

$env = parse_ini_file("../.env");
$request = ltrim($_SERVER['REQUEST_URI'], '/');
$shortcode = explode('/', $request)[0];
$url = 'https://stotzem.dev';

if (!empty($shortcode)) {
    try {
        $db = new PDO(
            'mysql:host=' . $env['SQL_HOSTNAME'] . ';dbname=' . $env['SQL_DATABASE'],
            $env['SQL_USERNAME'], $env['SQL_PASSWORD'],
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );

        $stmt = $db->prepare('SELECT url FROM shortcodes WHERE shortcode = ? LIMIT 1');
        $stmt->execute([$shortcode]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            $url = $result['url'];
        }
    } catch (PDOException $e) {
        die($e->getMessage());
    }
}

header('HTTP/1.1 302 Found');
header("Location: $url");
