<?php
namespace Yooway\Scenario\Model;


class Matrix
{
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
	public function pushWines(list) 
	{
		
	}
	/*
	* modifie juste un pinard dans une case (la liste est nécessaire pour prendre le premier de la liste qui est non encore utilisé)
	*/
	public function pushWine(til,list) 
	{
		
	}
	/*
	* modifie un widget question
	*/
	public function pushQuestion(til,question) 
	{
		
	}
}

?>