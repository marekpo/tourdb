<?php
class DisplayHelper extends AppHelper
{
	var $helpers = array('Html');

	var $yesNoDontKnowLabels;

	var $experienceLabels;

	var $publicTransportSubscriptionLabels;

	var $sexLabels;

	function __construct()
	{
		$this->yesNoDontKnowLabels = array(1 => __('Ja', true), 2 => __('Nein', true), 0 => __('Weiss nicht', true));
		$this->experienceLabels = array(__('Keine', true), __('Wenig',true), __('Mittel', true), __('Viel', true));
		$this->publicTransportSubscriptionLabels = array(__('1/2 Tax', true), __('GA', true));
		$this->sexLabels = array(__('weiblich', true), __('männlich', true));
	}

	function displayFlag($flag)
	{
		return $this->Html->tag('input', '', array('type' => 'checkbox', 'disabled' => 'disabled', 'checked' => ($flag == 1 ? 'checked' : '')));
	}

	function formatText($text)
	{
		$text = trim($text);

		$text = preg_replace('/(\r\n|\r|\n){2,}/', '</p><p>', $text);
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
		return $this->publicTransportSubscriptionLabels[$value];
	}

	function getSexOptions()
	{
		return $this->sexLabels;
	}

	function displaySex($value)
	{
		return $this->sexLabels[$value];
	}
}