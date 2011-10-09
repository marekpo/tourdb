<?php
class TourDisplayHelper extends AppHelper
{
	var $helpers = array('Html');

	function getTourGuide($tour)
	{
		$tourGuideProfile = null;

		if(isset($tour['Profile']))
		{
			$tourGuideProfile = $tour['Profile'];
		}
		elseif(isset($tour['TourGuide']['Profile']))
		{
			$tourGuideProfile = $tour['TourGuide']['Profile'];
		}

		if(empty($tourGuideProfile)
			|| !isset($tourGuideProfile['firstname'])
			|| empty($tourGuideProfile['firstname'])
			|| !isset($tourGuideProfile['lastname'])
			|| empty($tourGuideProfile['lastname'])
			)
		{
			return $tour['TourGuide']['username'];
		}

		return sprintf('%s %s', $tourGuideProfile['firstname'], $tourGuideProfile['lastname']);
	}

	function getClassification($tour, $options = array())
	{
		$options = array_merge(array(
			'span' => true
		), $options);

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

			$result = implode('/', $tourClassification);

			if($options['span'] == true)
			{
				return $this->Html->tag('span', $result, array('class' => 'tourClassification'));
			}

			return $result;
		}
	}
}