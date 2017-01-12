<?php


require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();

$app['debug'] = true;

require_once __DIR__.'/../app/rooting.php';

$app->run();