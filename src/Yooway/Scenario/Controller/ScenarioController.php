<?php
/**
 * Created by IntelliJ IDEA.
 * User: florentingarnier
 * Date: 13/01/2017
 * Time: 00:21
 */

namespace Yooway\Scenario\Controller;


use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Yooway\Scenario\Model\ScenarioModel;

/**
 * Class ScenarioController
 * @package Yooway\Scenario\Controller
 *
 *
 */
class ScenarioController
{
    public function scenarioAction(Request $request, Application $application)
    {

        $resultTest = new ScenarioModel();

        $result = $resultTest->dispatchYesNo(
            $request->get('prodRef'),
            $request->get('answer'),
            $request->get('tilId')
        );

        return $result;
    }
}