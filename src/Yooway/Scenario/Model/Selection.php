<?php
namespace Yooway\Scenario\Model;

/*
exemple de question :
"question1": {
   "type": "question",
   "libelle": "Pour l’apéritif ?",
    "criteria" : "aperitif",
   "nextStepYes": "question2",
   "nextStepNo": "question4"
 }

 */

class Selection
{

	public function __construct()
	{
	}

	public static function getSelection()
	{
		$var='{
    "type": "list",
    "item": [
      "plus de 5€",
      "plus de 10€",
      "plus de 20€",
      "plus de 40€",
      "plus de 100€"
    ]
  }
';
	return json_decode($var);

	}

}