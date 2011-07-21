<?php
class Menu extends AppModel
{
	var $name = 'Menu';

	var $displayField = 'caption';

	var $actsAs = array('Tree');
}