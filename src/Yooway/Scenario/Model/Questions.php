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

class Questions
{
	var $list;

	public function __construct()
	{
		$this->list=array();
		$questions = file_get_contents(__DIR__ . '/../JSON/questions.json');
        $questions=json_decode($questions);
        foreach($questions as $id=>$question)
        {
        	$question->id=$id;
        	$this->list[$id]=$question;
        }
	}

	/*
	* Fournit, à partir d'une question et d'une réponse, la question suivante
	* s'occupe également de gérer la liste des vins pour ajuster le tri
	*/
	public function question($id_question,$reponse, &$winelist)
	{
		$question=$this->findQuestion($id_question);
		if($question=="")
			return null;
		$no="no";
		$yes="yes";
		if(isset($question->right))
			$yes=strtolower($question->right);
		if(isset($question->left))
			$no=strtolower($question->left);
		if($reponse=="right")
		{
			$winelist->removeCriteriaBoolean($question->criteria,$no);
			$nextstep=$question->nextStepYes;
		}
		else
		{
			$winelist->removeCriteriaBoolean($question->criteria,$yes);
			$nextstep=$question->nextStepNo;
		}

		$next=$this->findQuestion($nextstep);
		if($next=="")
			$next=Matrix::getBlank();
		return $next;
	}

	/*
	* recherche d'une question à partir de son id
	*/
	public function findQuestion($id_rech)
	{
		if($id_rech=="")
			return null;
		foreach($this->list as $id=>$question)
		{
			if($id==$id_rech)
			{
				return $question;
			}
		}
		return null;
	}
}

?>