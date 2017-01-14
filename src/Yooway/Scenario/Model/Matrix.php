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
			if(!isset($case->old))
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
			if($case=="" || $case->type=="wine") // s'il n'y a rien ou si c'est déjà du vin, on peut insérer
				$this->matrix[$id]=array_shift($list);
		}
	}
	/*
	* modifie juste un pinard dans une case (la liste est nécessaire pour prendre le premier de la liste qui est non encore utilisé)
	*/
	public function pushWine($til,$list="") 
	{
		if($list=="")
			$list=$this->winelist->getList();
		foreach($list as $wine)
		{
			if($this->findWine($wine->id)==null)
			{
				$this->matrix[$til]=$wine;
				return;
			}
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
			if($case->type=="yesNoQuestion")
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