<?php

declare(strict_types=1);

use Laminas\Mvc\Application;
use Laminas\Stdlib\ArrayUtils;

/**
 * Display all errors when APPLICATION_ENV is development.
 */
//if ($_SERVER['APPLICATION_ENV'] === 'development') {
    error_reporting(E_ALL);
    ini_set("display_errors", '1');
//}

/**
 * This makes our life easier when dealing with paths. Everything is relative
 * to the application root now.
 */
chdir(dirname(__DIR__));

// Decline static file requests back to the PHP built-in webserver
if (php_sapi_name() === 'cli-server') {
    $path = realpath(__DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
    if (is_string($path) && __FILE__ !== $path && is_file($path)) {
        return false;
    }
    unset($path);
}

// Composer autoloading
include __DIR__ . '/../vendor/autoload.php';

if (! class_exists(Application::class)) {
    throw new RuntimeException(
        "Unable to load application.\n"
        . "- Type `composer install` if you are developing locally.\n"
        . "- Type `vagrant ssh -c 'composer install'` if you are using Vagrant.\n"
        . "- Type `docker-compose run laminas composer install` if you are using Docker.\n"
    );
}

// Retrieve configuration
$appConfig = require __DIR__ . '/../config/application.config.php';
if (file_exists(__DIR__ . '/../config/development.config.php')) {
    $appConfig = ArrayUtils::merge($appConfig, require __DIR__ . '/../config/development.config.php');
}

// Run the application!
Application::init($appConfig)->run();


// Temp!
/*function yt_exists($videoID) {
    $theURL = "http://www.youtube.com/oembed?url=http://www.youtube.com/watch?v=$videoID&format=json";
    $headers = get_headers($theURL);
    var_dump($headers);
    
    //$html = file_get_contents("http://www.youtube.com/oembed?url=http://www.youtube.com/watch?v=$videoID&format=json");
    //var_dump($html);

    return (substr($headers[0], 9, 3) !== "404");
}

$id = 'yyDUC1LUXSU'; //Video id goes here

if (yt_exists($id)) {
    echo "Yep, video is still up and running :)";
    //  Yep, video is still up and running :)
} else {
     echo "These aren't the droids you're looking for :(";
    //  These aren't the droids you're looking for :(
}
$id = 'kIboBC_-FRE';
if (yt_exists($id)) {
    echo "Yep, video is still up and running :)";
    //  Yep, video is still up and running :)
} else {
     echo "These aren't the droids you're looking for :(";
    //  These aren't the droids you're looking for :(
}*/