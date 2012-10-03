<?php
class TourDisplayHelper extends AppHelper
{
	var $helpers = array('Html','Time');

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
		elseif(isset($tour['Tour']['TourGuide']['Profile']))
		{
			$tourGuideProfile = $tour['Tour']['TourGuide']['Profile'];
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

		if(!isset($tour['TourType']))
		{
			if(!isset($tour['Tour']['TourType']))
			{
				return '';
			}

			$tour = $tour['Tour'];
		}

		$tourClassification = array(implode(', ', Set::extract('/TourType/acronym', $tour)));

		if(!empty($tour['ConditionalRequisite']))
		{
			$conditionalRequisites = Set::extract('/ConditionalRequisite/acronym', $tour);

			$tourClassification[] = in_array('A', $conditionalRequisites) && in_array('C', $conditionalRequisites)
				? 'ABC' : implode('', $conditionalRequisites);
		}

		if(!empty($tour['Difficulty']))
		{
			$difficulties = array();
			$climbingDifficulties = array();

			foreach($tour['Difficulty'] as $difficulty)
			{
				if(in_array(TourType::ALPINE_TOUR, Set::extract('/TourType/key', $tour)) && $difficulty['group'] == Difficulty::ROCK_CLIMBING)
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
	
	function getDeadlineText($tour)
	{
		
		$deadLineText = '';

		if(isset($tour['Tour'])) {		
			if($tour['Tour']['signuprequired'])
			{
				$deadLineText = $this->Time->format('d.m.Y', $tour['Tour']['deadline_calculated']); 
			}
			else
			{
				$deadLineText = __('ohne', True);
			}
		}
		
		return $deadLineText;
	}
	
	function getStatusLink($tour,$action)
	{
	
		$statusIcon = '';
		$statusText = '';
		$statusLink = '';
	
		if(isset($tour['TourStatus'])) {
			if($tour['TourStatus']['key'] == TourStatus::NEW_ )
			{
				$statusIcon = 'white';
				$statusText = __('Neue Tour editieren.', true);
			
			}
			elseif($tour['TourStatus']['key'] == TourStatus::FIXED )
			{
				$statusIcon = 'orange';
				$statusText = __('Anmeldung noch nicht möglich.', true);
				
			}
			elseif($tour['TourStatus']['key'] == TourStatus::PUBLISHED )
			{
				$statusIcon = 'green';
				$statusText = __('Anmeldung möglich.', true);
			}
			elseif($tour['TourStatus']['key'] == TourStatus::CANCELED )
			{
				$statusIcon = 'red';
				$statusText = __('Keine Anmeldung möglich. Tour wurde abgesagt.', true);
			}
			elseif($tour['TourStatus']['key'] == TourStatus::REGISTRATION_CLOSED )
			{
				$statusIcon = 'red';
				$statusText = __('Keine Anmeldung mehr möglich. Anmeldung wurde geschlossen.', true);
			}			
			else
			{
				$statusIcon = 'white';
				$statusText = __('Tour liegt in der Vergangenheit.', true);
			}	
			
		}
	
		$statusLink = $this->Html->link('', array('controller' => 'tours', 'action' => $action, $tour['Tour']['id']), array(
						'class' => sprintf('iconstatus %s', $statusIcon),
						'id' => sprintf('edit-%s', $tour['Tour']['id']),
						'title' => $statusText
				));
		
		return $statusLink; 			
		;
	}
	
	
}