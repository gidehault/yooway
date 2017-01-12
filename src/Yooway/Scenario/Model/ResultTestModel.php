<?php
/**
 * Created by IntelliJ IDEA.
 * User: florentingarnier
 * Date: 13/01/2017
 * Time: 00:44
 */

namespace Yooway\Scenario\Model;


class ResultTestModel
{
    public function detectCommunication($prodRef, $answer)
    {
        if (isset($prodRef) && isset($answer)){
            $result = 'success';
        } else {
            $result = 'fail';
        }

        return $result;
    }

}