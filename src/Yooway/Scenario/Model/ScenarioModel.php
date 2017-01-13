<?php
/**
 * Created by IntelliJ IDEA.
 * User: florentingarnier
 * Date: 13/01/2017
 * Time: 00:44
 */

namespace Yooway\Scenario\Model;


class ScenarioModel
{
    /**
     * @param $prodRef
     * @param $answer
     * @param $tilId identifiant envoyé par yooway.js
     * @return string
     */
    public function dispatchYesNo($prodRef, $answer, $tilId)
    {
        if (isset($prodRef) && isset($answer)) {
            $step = file_get_contents(__DIR__ . '/../JSON/questions.json');
            $step = json_decode($step);
            if ($answer === "left") {

                if ($prodRef === "question1") {
                    return $this->questionBuilder($prodRef, $step, $tilId);
                }

            } else if ($answer === 'right') {

                if ($prodRef === "question2") {

                    return $this->questionBuilder($prodRef, $step, $tilId);

                }
            }

        } else {
            return 'fail';
        }


    }

    private function questionBuilder($questionNb, $step, $tilId)
    {
        //Surcharge l'objet json pour savoir d'oùu viens le drag.
        $step->$questionNb->til = $tilId;

        $content = json_encode($step->$questionNb);

        return $content;
    }

}