<?php
class TourDisplayHelper extends AppHelper
{
	var $helpers = array('Html', 'Time');

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

		if(isset($tour['Tour']))
		{
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

	function getStatusLink($tour, $action)
	{
		list($linkClass, $linkTitle) = $this->__getStatusClassAndTitle($tour);

		if(array_key_exists('Tour', $tour))
		{
			$tour = $tour['Tour'];
		}

		return $this->Html->link('', array('controller' => 'tours', 'action' => $action, $tour['id']), array(
			'class' => sprintf('tourstatus %s', $linkClass), 'id' => sprintf('view-%s', $tour['id']), 'title' => $linkTitle
		));;
	}

	function getStatusIcon($tour)
	{
		list($iconClass, $iconTitle) = $this->__getStatusClassAndTitle($tour);

		return $this->Html->div(sprintf('tourstatus %s', $iconClass), '', array('title' => $iconTitle));
	}

	function __getStatusClassAndTitle($tour)
	{
		$statusClass = '';
		$statusTitle = '';

		$tourStatus = $tour['TourStatus'];

		if(array_key_exists('Tour', $tour))
		{
			$tour = $tour['Tour'];
		}

		if(isset($tourStatus))
		{
			if(time() >= strtotime($tour['startdate']))
			{
				$statusClass = 'past';
				$statusTitle = __('Tour liegt in der Vergangenheit.', true);
			}
			else
			{
				switch($tourStatus['key'])
				{
					case TourStatus::FIXED:
						$statusClass = 'fixed';
						$statusTitle = __('Anmeldung ist noch nicht möglich.', true);
						break;
					case TourStatus::PUBLISHED:
						if(strtotime($tour['deadline_calculated']) >= strtotime(date('Y-m-d')))
						{
							$statusClass = 'signup_open';
							$statusTitle = $tour['signuprequired'] ? __('Anmeldung ist möglich.', true) : __('Anmeldung ist nicht nötig.', true);
						}
						else
						{
							$statusClass = 'signup_closed';
							$statusTitle = __('Anmeldung ist abgelaufen.', true);
						}
						break;
					case TourStatus::CANCELED:
						$statusClass = 'signup_closed';
						$statusTitle = __('Keine Anmeldung möglich. Tour wurde abgesagt.', true);
						break;
					case TourStatus::REGISTRATION_CLOSED:
						$statusClass = 'signup_closed';
						$statusTitle = __('Keine Anmeldung möglich. Anmeldung wurde geschlossen.', true);
						break;
				}
			}
		}

		return array($statusClass, $statusTitle);
	}
}