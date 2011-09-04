<?php
class TourDisplayHelper extends AppHelper
{
	var $helpers = array('Html');

	function getTourGuide($tour)
	{
		if(!isset($tour['TourGuide']['Profile'])
			|| !isset($tour['TourGuide']['Profile']['firstname'])
			|| empty($tour['TourGuide']['Profile']['firstname'])
			|| !isset($tour['TourGuide']['Profile']['lastname'])
			|| empty($tour['TourGuide']['Profile']['lastname'])
			)
		{
			return $tour['TourGuide']['username'];
		}

		return sprintf('%s %s', $tour['TourGuide']['Profile']['firstname'], $tour['TourGuide']['Profile']['lastname']);
	}

	function getClassification($tour)
	{
		$tourClassification = array();

		if(!empty($tour['TourType']))
		{
			$tourTypes = array();

			foreach($tour['TourType'] as $tourType)
			{
				$tourTypes[] = $tourType['acronym'];
			}

			$tourClassification[] = implode(', ', $tourTypes);
		}

		if(!empty($tour['ConditionalRequisite']))
		{
			$conditionalRequisites = array();

			foreach($tour['ConditionalRequisite'] as $conditionalRequisite)
			{
				$conditionalRequisites[] = $conditionalRequisite['acronym'];
			}

			$tourClassification[] = implode('-', $conditionalRequisites);
		}

		if(!empty($tour['Difficulty']))
		{
			$difficulties = array();

			foreach($tour['Difficulty'] as $difficulty)
			{
				$difficulties[] = $difficulty['name'];
			}

			$tourClassification[] = implode('-', $difficulties);
		}

		return implode('/', $tourClassification);
	}
}