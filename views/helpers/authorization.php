<?php
if (!class_exists('TourDBAuthorization'))
{
	App::import('Lib', 'TourDBAuthorization');
}

class AuthorizationHelper extends TourDBAuthorization
{
	var $helpers = array();
}