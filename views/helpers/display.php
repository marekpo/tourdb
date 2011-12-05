<?php
class DisplayHelper extends AppHelper
{
	var $helpers = array('Html');

	var $yesNoDontKnowLabels = array(
		'Weiss nicht', 'Ja', 'Nein'
	);

	var $experienceLabels = array(
		'Keine', 'Wenig', 'Mittel', 'Viel'
	);

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

	function displayYesNoDontKnow($value)
	{
		return $this->yesNoDontKnowLabels[$value];
	}

	function displayExperience($value)
	{
		return $this->experienceLabels[$value];
	}
}