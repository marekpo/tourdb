<?php
class AppModel extends Model
{
	var $actsAs = array('Containable');

	function compareToDateField($check, $operator, $otherDateField)
	{
		$checkTimestamp = strtotime(array_pop($check));
		$otherTimestamp = strtotime($this->data[$this->alias][$otherDateField]);

		switch($operator)
		{
			case '>':
				if($checkTimestamp > $otherTimestamp)
				{
					return true;
				}
				break;
			case '<':
				if($checkTimestamp < $otherTimestamp)
				{
					return true;
				}
				break;
			case '>=':
				if($checkTimestamp >= $otherTimestamp)
				{
					return true;
				}
				break;
			case '<=':
				if($checkTimestamp <= $otherTimestamp)
				{
					return true;
				}
				break;
			case '==':
				if($checkTimestamp == $otherTimestamp)
				{
					return true;
				}
				break;
			case '!=':
				if($checkTimestamp != $otherTimestamp)
				{
					return true;
				}
				break;
			default:
				$validation =& Validation::getInstance();
				$validation->errors[] = __('You must define the $operator parameter for AppModel::compareDate() validation rule.', true);
		}

		return false;
	}
}