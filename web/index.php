<?php


require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();

//active le debug à true
require_once __DIR__ . '/../app/config/dev.php';
require_once __DIR__ . '/../app/app.php';
require_once __DIR__ . '/../app/routing.php';

$app->run();