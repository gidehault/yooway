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
use Yooway\Scenario\Model\Matrix;
use Yooway\Scenario\Model\ScenarioModel;

/**
 * Class ScenarioController
 * @package Yooway\Scenario\Controller
 *
 *
 */
class ScenarioController
{
    /**
     * @param Request $request
     * @param Application $application
     * @return string
     */
    public function scenarioAction(Request $request, Application $application)
    {
        $matrix=$application['session']->get('matrix');
        if($matrix=="")
        {
            $matrix=new Matrix();
            // création d'une premiere matrice
            $questions=new Questions();
            $matrix->pushElement(4,$questions->findQuestion("question4"));
            $matrix->pushWines(;

            $application['session']->set('matrix',$matrix);
        }

        $prodref=$request->get('prodRef');
        $answer=$request->get('answer');
        $tilId=$request->get('tilId');
        $type=""; // question, wine, selection
        $critere=""; // encodé dans la question
        $valeur=""; // valeur de sélection


        if($type=="question")
        {
            $matrix->winelist->removeCriteriaBoolean($critere,$answer);
            $matrix->pushWines();
        }
        if($type=="wine")
        {
            $matrix->winelist->removeWine($prodref);
            $matrix->pushWine($tilId);
        }
        if($type=="selection")
        {
            $matrix->winelist->removePrice($valeur);
            $matrix->pushWines();
        }
        return $matrix->getDirectives();

//        $directive = file_get_contents(__DIR__ . '/../JSON/directive.json');
//      return $directive;
    }

}