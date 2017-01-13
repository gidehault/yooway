<?php
namespace Yooway\Scenario\Model;


class Matrix
{
	var $matrix;

	public function __construct()
	{
		$this->matrix=array();
		for($i=0;$i<9;$i++)
			$this->matrix[$i]="";
	}
	/*
	* retourne le json des directives à envoyer au js
	*/
	public function getDirectives() 
	{
		foreach($this->matrix as $id=>$case)
		{
			if($case->old!="ok")
			{
				$directives[$id]=$case;
			}
		}
		$this->reset();
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
	public function pushWines($list) 
	{
		foreach($this->matrix as $case)
		{
			if($case=="" || $case->type=="wine")
				$newlist[]=array_shift($list);
			else
				$newlist[]=$case;
		}
		$this->matrix=$newlist;
	}
	/*
	* modifie juste un pinard dans une case (la liste est nécessaire pour prendre le premier de la liste qui est non encore utilisé)
	*/
	public function pushWine($til,$list) 
	{
		foreach($list as $wine)
		{
			if($this->findWine($wine->id)==null)
			{
				$this->matrix[$til]==$wine;
				return;
			}
		}
	}
	public function findWine($id)
	{
		foreach($this->matrix as $case)
		{
			if($case->type=="wine" && $case->id==$id)
				return $wine;
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
	*/
	public function changeQuestion($question) 
	{
		foreach($this->matrix as $id=>$case)
		{
			if($case->type=="question")
				$this->matrix[$id]=$question;
		}
	}
	/*
	* Réinitialise tous les éléments de la matrice en les marquant comme 'vieux'
	*/
	public function reset()
	{
		foreach($this->matrix as &$case)
		{
			$case->old=="ok";
		}
	}
}

?>