<?php
namespace Yooway\Scenario\Model;


class Matrix
{
	var $matrix;
	var $winelist;
	var $questions;

	public function __construct()
	{
		$this->matrix=array();
		for($i=0;$i<9;$i++)
			$this->matrix[$i]="";

		$this->winelist=new WineList();
		$this->questions=new Questions();
	}
	/*
	* retourne le json des directives à envoyer au js
	*/
	public function getDirectives() 
	{
		$directives = (object) [];
		foreach($this->matrix as $id=>$case)
		{
			if($case!="" && !isset($case->old))
			{
				$til="til-".$id;
				$directives->$til=$case;
			}
		}
		$this->old();
		return $directives;
		//return $this->getDirectivesMockup();
	}
	private function getDirectivesMockup()
	{
	    $directives = file_get_contents(__DIR__ . '/../JSON/directive.json');
        return json_decode($directives);
	}
	/*
	*	répartit des pinards dans la matrice
	*/
	public function pushWines($list="") 
	{
		if($list=="")
			$list=$this->winelist->getList();
		foreach($this->matrix as $id=>$case)
		{

			if($case=="" || ($case!="" && ($case->type=="wine" || $case->type=="blank"))) // s'il n'y a rien ou si c'est déjà du vin, on peut insérer
			{	
				$wine=array_shift($list);
				if($wine=="")
					$this->matrix[$id]=self::getBlank();
				else if($case=="" || ($case!="" && $wine->id!=$case->id)) // pas la peine de le remplacer s'il y est déjà
				{
					unset($wine->old);
					$this->matrix[$id]=$wine;
				}
			}
		}
	}
	public static function getBlank()
	{
		$blank = (object) [];
		$blank->type="blank";
		return $blank;
	}

	/**
	 * modifie juste un pinard dans une case (la liste est nécessaire pour prendre le premier de la liste qui est non encore utilisé)
     * Lorsque l'utilisateur n'aime pas, la case devient blank et potentielement en attente pour être rempli.
     *
     * @param string $til ID de la tuile en cours
     * @param string $answer besoin pour supprimer le vin qu'on aime pas.
     * @param array $list liste des vins
     *
     * @return mixed
	 */
	public function pushWine($til, $answer, $list=[])
	{
	    if ($answer === "right"){
            if(empty($list))
                $list=$this->winelist->getList();
            foreach($list as $wine)
            {
                if($this->findWine($wine->id)==null)
                {
                    unset($wine->old);
                    $this->matrix[$til]=$wine;
                    return;
                }
            }
        } else if (empty($list)){
	        $this->matrix[$til] = self::getBlank();
        }

	}
	public function findWine($id)
	{
		foreach($this->matrix as $case)
		{
			if($case->type=="wine" && $case->id==$id)
			{
				return $case;
			}
		}
		return null;
	}
	/*
	* modifie un widget quelconque (question, bloc de sélection...)
	*/
	public function pushElement($til,$element) 
	{
		$this->matrix[$til]=$element;
	}
	/*
	* met à jour le bloc question
	* (en prenant l'emplacement du premier bloc question qu'il trouve...)
	*/
	public function changeQuestion($question) 
	{
		foreach($this->matrix as $id=>$case)
		{
			if($case->type=="yesNoQuestion" || $case->type=="questionWithChoice")
				$this->matrix[$id]=$question;
		}
	}
	/*
	* Réinitialise tous les éléments de la matrice en les marquant comme 'vieux'
	*/
	public function old()
	{
		foreach($this->matrix as &$case)
		{
			if($case!="")
				$case->old="ok";
		}
	}
	/*
	* Réinitialise tous les éléments de la matrice afin qu'ils apparaissent tous lors du prochain appel à getDirectives()
	*/
	public function reset()
	{
		foreach($this->matrix as &$case)
		{
			unset($case->old);
		}
		$this->winelist->reset();
	}
}

?>