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

        // On commence par initialiser l'objet matrix à partir de la session
        if(!isset($_SESSION['matrix']))
        {
            $matrix=new Matrix();
            // création d'une premiere matrice
            $matrix->pushElement(2,Selection::getSelection());
            $question=$matrix->questions->findQuestion("question1");
            $matrix->pushElement(3,$question);
            $matrix->pushWines();
        }
        else
            $matrix=$_SESSION['matrix'];

        // paramètres en provenance du front
        $init=$request->get('init');
        $prodref=$request->get('prodRef');
        $answer=$request->get('answer');
        $tilId=$request->get('tilId');
        $tilId=substr($tilId,strlen($tilId)-1);
        $type=$request->get('type'); // question, wine, selection

        // si premier affichage, on force un réinit des éléments de la matrice
        if($init==1)
            $matrix->reset();

        // traitement des informations en entrée, suivant le type de widget qui communique
        if($type=="yesNoQuestion")
        {
            $nouvellequestion=$matrix->questions->question($prodref,$answer,$matrix->winelist);
            $matrix->changeQuestion($nouvellequestion);
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

        // c'est fini, on stocke la matrice revue en session, et on génère les directives qui sont renvoyées au client
        $_SESSION['matrix']=$matrix;
        return json_encode($matrix->getDirectives());
    }

}