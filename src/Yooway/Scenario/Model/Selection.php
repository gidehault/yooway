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
      {"price":"5","libelle":"plus de 5€"},
      {"price":"10","libelle": "plus de 10€"},
      {"price":"20","libelle": "plus de 20€"},
      {"price":"40","libelle": "plus de 40€"},
      {"price":"100","libelle": "plus de 100€"}
    ]
  }
';
//echo $var;
	return json_decode($var);

	}

}