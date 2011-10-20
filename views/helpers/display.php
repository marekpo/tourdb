<?php
class DisplayHelper extends AppHelper
{
	var $helpers = array('Html');

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
}