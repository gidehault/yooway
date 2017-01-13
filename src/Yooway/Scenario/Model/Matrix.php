<?php
namespace Yooway\Scenario\Model;


class Matrix
{
	var $matrix;

	public function __construct()
	{
		$this->matrix=array();
	}
	/*
	* retourne le json des directives à envoyer au js
	*/
	public function getDirectives() 
	{
		return $this->getDirectivesMockup();
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
		foreach($this->list as $case)
		{
			if($case->type="wine")
				$newlist[]=array_shift($wine);
			else
				$newlist[]=$case;
		}
		$this->list=$newlist;
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
		foreach($this->list as $wine)
		{
			if($wine->id==$id)
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
}

?>