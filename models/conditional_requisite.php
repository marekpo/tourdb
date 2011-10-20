<?php
class ConditionalRequisite extends AppModel
{
	var $name = 'ConditionalRequisite';

	var $hasAndBelongsToMany = array('Tour');
}