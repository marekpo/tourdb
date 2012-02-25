<?php
class AppModel extends Model
{
	var $actsAs = array('Containable');

	function validateName($check)
	{
		$check = array_pop($check);

		$_this =& Validation::getInstance();
		$_this->__reset();
		$_this->check = $check;
		
		if(is_array($check))
		{
			$_this->_extract($check);
		}
		
		if(empty($_this->check))
		{
			return false;
		}

		$_this->regex = '/^[\p{Ll}\p{Lm}\p{Lo}\p{Lt}\p{Lu}\-\. ]+$/mu';

		return $_this->_check();
	}

	function validatePhone($check)
	{
		$check = array_pop($check);

		$_this =& Validation::getInstance();
		$_this->__reset();
		$_this->check = $check;

		if(is_array($check))
		{
			$_this->_extract($check);
		}

		if(empty($_this->check))
		{
			return false;
		}

		$_this->regex = '/^([0-9+])[0-9 ]*$/';

		return $_this->_check();
	}

	function compareToDateField($check, $operator, $otherDateField)
	{
		$checkTimestamp = strtotime(array_pop($check));

		$otherFieldValue = isset($this->data[$this->alias][$otherDateField]) ? $this->data[$this->alias][$otherDateField] : $this->field($otherDateField, array('id' => $this->data[$this->alias]['id']));
		$otherTimestamp = strtotime($otherFieldValue);

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