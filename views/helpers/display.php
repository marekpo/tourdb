<?php
class DisplayHelper extends AppHelper
{
	var $helpers = array('Html');

	function displayFlag($flag)
	{
		return $flag == 1 ? $this->Html->image('checkbox_checked.png') : $this->Html->image('checkbox_checked.png');
	}
}