<?php
/**
 * app/routing.php
 *
 * Collect all route for application
 */

/**
 * Homepage
 */
$app->get('/', 'Yooway\Home\Controller\HomeController::indexAction')
    ->bind('homepage');

/**
 * API Yooway
 */
$app->post('/scenario', 'Yooway\Scenario\Controller\ScenarioController::scenarioAction')
    ->bind('api');