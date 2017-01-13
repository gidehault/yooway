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
    public function detectCommunication($prodRef, $answer, $tilId)
    {
        if (isset($prodRef) && isset($answer)){
            $step = file_get_contents(__DIR__ . '/step.json');
            $step = json_decode($step);
            $content = "";

            if ($answer === "left"){
                //Regarde si c'est une question ou un produit et renvoi le contenu de la prochaine tuile
                if ($prodRef === "question1"){
                    $content = $step->question2->content;
                    $type = $step->question2->type;
                    $content = json_encode([
                        "type" => $type,
                        "content" => $content,
                        "til" => $tilId
                    ]);

                }
                return $content;
            }

        } else {
            return 'fail';
        }


    }

}