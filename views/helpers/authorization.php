<?php
if (!class_exists('TourDBAuthorization'))
{
	App::import('Lib', 'TourDBAuthorization');
}

class AuthorizationHelper extends TourDBAuthorization
{
	var $helpers = array('Html');

	function link($title, $url = null, $options = array(), $confirmMessage = false)
	{
		$linkUrl = $this->Html->url($url !== null ? $url : $title);
		$this->log(var_export(Router::parse($linkUrl), true));
		
		$beforeTime = microtime(true);
		Router::parse($linkUrl);
		$this->log(microtime(true) - $beforeTime);

		return $this->Html->link($title, $url, $options, $confirmMessage);
	}
}