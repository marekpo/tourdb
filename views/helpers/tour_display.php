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

		$tourTypes = array();

		foreach($tour['TourType'] as $tourType)
		{
			$tourTypes[] = $tourType['acronym'];
		}

		$tourType = implode(', ', $tourTypes);

		if($tourType == 'Exk')
		{
			return $tourType;
		}
		else
		{
			$tourClassification = array($tourType);

			if(!empty($tour['ConditionalRequisite']))
			{
				$conditionalRequisites = array();

				foreach($tour['ConditionalRequisite'] as $conditionalRequisite)
				{
					$conditionalRequisites[] = $conditionalRequisite['acronym'];
				}

				$tourClassification[] = in_array('A', $conditionalRequisites) && in_array('C', $conditionalRequisites)
					? 'ABC' : implode('', $conditionalRequisites);
			}

			if(!empty($tour['Difficulty']))
			{
				$difficulties = array();
				$climbingDifficulties = array();

				foreach($tour['Difficulty'] as $difficulty)
				{
					if($tourType == 'H' && $difficulty['group'] == Difficulty::ALPINE_TOUR)
					{
						$climbingDifficulties[] = $difficulty['name'];
						continue;
					}

					$difficulties[] = $difficulty['name'];
				}


				if(!empty($climbingDifficulties))
				{
					$tourClassification[] = implode(', ', array(implode(' - ', $difficulties), implode(' - ', $climbingDifficulties)));
				}
				else
				{
					$tourClassification[] = implode(' - ', $difficulties);
				}

			}

			return $this->Html->tag('span', implode('/', $tourClassification), array('class' => 'tourClassification'));
		}
	}
}