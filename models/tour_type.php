<?php
class TourType extends AppModel
{
	var $name = 'TourType';

	var $hasAndBelongsToMany = array('Tour');

	function init()
	{
		$tourTypes = array(
			array(
				'title' => 'Plaisir-Tour',
				'acronym' => 'P'
			),
			array(
				'title' => 'Klettertour mit Normal- und oder Bohrhaken',
				'acronym' => 'K'
			),
			array(
				'title' => 'Klettersteigtour',
				'acronym' => 'KS'
			),
			array(
				'title' => 'Hochtour',
				'acronym' => 'H'
			),
			array(
				'title' => 'Wanderung',
				'acronym' => 'W'
			),
			array(
				'title' => 'Ski- oder Snowboardtour',
				'acronym' => 'S'
			),
			array(
				'title' => 'Schneeschuhtour oder -wanderung',
				'acronym' => 'SS'
			),
			array(
				'title' => 'Langlauf',
				'acronym' => 'LL',
			),
			array(
				'title' => 'Mountain Bike-Tour',
				'acronym' => 'MTB'
			),
			array(
				'title' => 'Exkursion',
				'acronym' => 'Exk'
			)		
		);

		$this->deleteAll(array('1' => '1'));

		foreach($tourTypes as $tourType)
		{
			$this->create();
			$this->save(array('TourType' => $tourType));
		}
	}
}