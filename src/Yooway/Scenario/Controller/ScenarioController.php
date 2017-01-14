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
use Yooway\Scenario\Model\Questions;
use Yooway\Scenario\Model\Selection;
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
        session_start();

        if(!isset($_SESSION['matrix']))
        {
            $matrix=new Matrix();
            // création d'une premiere matrice
            $matrix->pushElement(2,Selection::getSelection());
            $matrix->pushElement(3,$matrix->questions->findQuestion("question4"));
            $matrix->pushWines();
        }
        else
            $matrix=$_SESSION['matrix'];

        $init=$request->get('init');
        $prodref=$request->get('prodRef');
        $answer=$request->get('answer');
        $tilId=$request->get('tilId');
        $type=$request->get('type'); // question, wine, selection

        if($init==1)
            $matrix->reset();

        if($type=="question")
        {
            $matrix->questions->question($prodref,$answer,$matrix->winelist);
            $matrix->pushWines();
        }
        if($type=="wine")
        {
            $matrix->winelist->removeWine($prodref);
            $matrix->pushWine($tilId);
        }
        if($type=="selection")
        {
            $matrix->winelist->removePrice($answer);
            $matrix->pushWines();
        }

        $_SESSION['matrix']=$matrix;
        return json_encode($matrix->getDirectives());
    }

}