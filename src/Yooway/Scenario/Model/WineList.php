<?php
namespace Yooway\Scenario\Model;


class WineList
{
	var $list;

	public function __construct()
	{
		$this->list=array();
		$wines = file_get_contents(__DIR__ . '/../JSON/wines.json');
        $wines=json_decode($wines);
        foreach($wines as $id=>$wine)
        {
        	$wine->id=$id;
        	$wine->available=true;
        	$this->list[]=$wine;
        }
	}
	/*
	* génère la liste complète des vins sélectionnés
	*/
	public function getList()
	{
		foreach($this->list as $wine)
		{
			if($wine->available==true)
				$selectionne[]=$wine;
		}
		return $selectionne;
	}
	/*
	* tri des vins en enlevant un critere
	*/
	public function removeCriteriaBoolean($nomcritere,$valeurafiltrer)
	{
		foreach($this->list as &$wine)
		{
			if($wine->$nomcritere==$valeurafiltrer)
				$wine->available=false;
		}
	}
	/*
	* tri des vins en enlevant ceux qui n'ont pas un bon prix
	*/
	public function removePrice($prixagarder)
	{
		foreach($this->list as &$wine)
		{
			$prix=$this->convert($wine->price);
			if($prix<$prixagarder-20 || $prix>$prixagarder+20)
				$wine->available=false;
		}
		
	}
	private function convert($text)
	{
		return 0;
	}
	/*
	* suppression d'un vin en particulier
	*/
	public function removeWine($id)
	{
		foreach($this->list as &$wine)
		{
			if($wine->id==$id)
				$wine->available=false;
		}
	}
	/**
	* rend à nouveau tous les vins accessibles
	*/
	public function reset()
	{		
		foreach($this->list as &$wine)
		{
			$wine->available=true;
		}
	}
}

?>