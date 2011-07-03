<?php
class DisplayHelper extends AppHelper
{
	var $helpers = array('Html');

	function displayFlag($flag)
	{
		return $flag == 1 ? $this->Html->image('accept.png') : $this->Html->image('delete.png');
	}
}