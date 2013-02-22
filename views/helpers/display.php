<?php
class DisplayHelper extends AppHelper
{
	var $helpers = array('Html', 'Time');

	var $yesNoDontKnowLabels;

	var $experienceLabels;

	var $publicTransportSubscriptionLabels;

	var $sexLabels;

	var $transportLabels;

	var $sacMemberLabels;

	function __construct()
	{
		$this->yesNoDontKnowLabels = array(1 => __('Ja', true), 2 => __('Nein', true), 0 => __('Weiss nicht', true));
		$this->experienceLabels = array(__('Keine', true), __('Wenig',true), __('Mittel', true), __('Viel', true));
		$this->publicTransportSubscriptionLabels = array(__('1/2 Tax', true), __('GA', true));
		$this->sexLabels = array(__('weiblich', true), __('männlich', true));
		$this->transportLabels = array(__('ÖV (Bus, Bahn)', true), __('PKW', true), __('Taxi', true));
		$this->sacMemberLabels = array(__('Nein (Gast)', true), __('Ja (Mitglied)', true));
	}

	function displayFlag($flag)
	{
		return $this->Html->tag('input', '', array('type' => 'checkbox', 'disabled' => 'disabled', 'checked' => ($flag == 1 ? 'checked' : '')));
	}

	function formatText($text)
	{
		$text = trim($text);

		$text = preg_replace_callback('/(http(?:s)?:\/\/[^\s\r\n]+)/', array($this, '__replaceUrlCallback'), $text);

		$text = preg_replace('/(\r\n\r\n|\r\r|\n\n)/', '</p><p>', $text);
		$text = preg_replace('/(\r\n|\r|\n)/', '<br />', $text);

		return $this->Html->para('', $text);
	}

	function displayUsersFirstName($username, $profile)
	{
		if(!$profile || empty($profile['firstname']))
		{
			return $username;
		}

		return $profile['firstname'];
	}

	function displayUsersFullName($username, $profile)
	{
		if(!$profile || empty($profile['firstname']) || empty($profile['lastname']))
		{
			return $username;
		}

		return sprintf('%s %s', $profile['firstname'], $profile['lastname']);
	}

	function getDateRangeText($startDate, $endDate, $year = false, $onlyStartDate = false)
	{
		$dateRangeText = '';

		$startTime = strtotime(date('d.m.Y', strtotime($startDate)));
		$endTime = strtotime(date('d.m.Y', strtotime($endDate)));

		$dateRangeText = sprintf('%s.%s.', $this->Time->format('d', $startTime), $this->Time->format('m', $startTime));
		if($year)
		{
			$dateRangeText = $dateRangeText . $this->Time->format('Y', $startTime);
		}

		$duration = $endTime - $startTime;
		if($duration > 0 && !$onlyStartDate)
		{
			$dateRangeText = sprintf('%s-%s.%s.', $dateRangeText, $this->Time->format('d', $endTime), $this->Time->format('m', $endTime));
			if($year)
			{
				$dateRangeText = $dateRangeText . $this->Time->format('Y', $endTime);
			}
		}

		return $dateRangeText;
	}

	function getDayOfWeekText($startDate, $endDate)
	{
		$startTime = strtotime(date('d.m.Y', strtotime($startDate)));
		$endTime = strtotime(date('d.m.Y', strtotime($endDate)));

		$dayOfWeekText = $this->Time->format($startTime, '%a');

		$duration = $endTime - $startTime;
		if($duration > 0)
		{
			$dayOfWeekText = sprintf('%s-%s', $dayOfWeekText, $this->Time->format($endTime, '%a'));
		}

		return $dayOfWeekText;
	}

	function getYesNoDontKnowOptions()
	{
		return $this->yesNoDontKnowLabels;
	}

	function displayYesNoDontKnow($value)
	{
		return $this->yesNoDontKnowLabels[$value];
	}

	function getExperienceOptions()
	{
		return $this->experienceLabels;
	}

	function displayExperience($value)
	{
		return $this->experienceLabels[$value];
	}

	function getPublicTransportSubscriptionOptions()
	{
		return $this->publicTransportSubscriptionLabels;
	}

	function displayPublicTransportSubscription($value)
	{
		return (empty($value) && !is_numeric($value) ? '' : $this->publicTransportSubscriptionLabels[$value]);
	}

	function getSexOptions()
	{
		return $this->sexLabels;
	}

	function displaySex($value)
	{
		return $this->sexLabels[$value];
	}

	function getTransportOptions()
	{
		return $this->transportLabels;
	}

	function displayTransport($value)
	{
		return $this->transportLabels[$value];
	}

	function displayUsersPhoneContact($profile)
	{
		if($profile && !empty($profile['cellphone']))
		{
			return $profile['cellphone'];
		}

		if($profile && !empty($profile['phoneprivate']))
		{
			return $profile['phoneprivate'];
		}

		return '';
	}

	function getSacMemberOptions()
	{
		return $this->sacMemberLabels;
	}

	function displaySacMember($value)
	{
		if($value == null)
		{
			return __('Unbekannt', true);
		}

		return $this->sacMemberLabels[$value];
	}

	function __replaceUrlCallback($match)
	{
		return $this->Html->link($match[0], $match[0], array('target' => '_blank'));
	}
}