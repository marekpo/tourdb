<?php
App::import('Lib', 'SecurityTools');

class User extends AppModel
{
	var $name = 'User';

	var $validate = array(
		'username' => array(
			'alphaNumeric' => array(
				'rule' => 'alphaNumeric'
			),
			'isUnique' => array(
				'rule' => 'isUnique'
			),
			'length' => array(
				'rule' => array('between', 5, 15)
			)
		),
		'email' => array(
			'email' => array(
				'rule' => 'email'
			),
			'isUnique' => array(
				'rule' => 'isUnique'
			)
		),
		'tempPassword' => array(
			'empty' => array(
				'rule' => 'notEmpty'
			),
			'wrong' => array(
				'rule' => 'correctTempPassword'
			)
		),
		'newPassword' => array(
			'empty' => array(
				'rule' => 'notEmpty'
			)
		),
		'newPasswordRepeat' => array(
			'mismatch' => array(
				'rule' => array('identicalFields', 'newPassword')
			)
		)
	);

	function correctTempPassword($field)
	{
		$value = array_pop($field);

		$passwordData = $this->findById($this->data['User']['id'], array('User.salt', 'User.password'));

		return Security::hash($passwordData['User']['salt'] . $value, 'sha1', false) == $passwordData['User']['password'];
	}

	function identicalFields($field, $compareField)
	{
		$value = array_pop($field);

		return $value === $this->data[$this->name][$compareField];
	}

	function createAccount($username, $email, &$password)
	{
		$this->create(array(
			'User' => array(
				'username' => $username,
				'email' => $email
			)
		));

		$salt = SecurityTools::generateRandomString();
		$password = SecurityTools::generateRandomString(8);

		$this->data['User']['salt'] = $salt;
		$this->data['User']['password'] = Security::hash($salt . $password, 'sha1', false);

		return $this->save();
	}

	function activateAccount($id, $tempPassword, $newPassword, $newPasswordRepeat)
	{
		$this->create(array(
			'User' => array(
				'id' => $id,
				'tempPassword' => $tempPassword,
				'newPassword' => $newPassword,
				'newPasswordRepeat' => $newPasswordRepeat
			)
		));

		if(!$this->validates())
		{
			return false;
		}

		$salt = SecurityTools::generateRandomString();

		return $this->save(array(
			'User' => array(
				'id' => $id,
				'salt' => $salt,
				'password' => Security::hash($salt . $newPassword, 'sha1', false),
				'active' => 1
			)
		));
	}

	function isActive($id = null)
	{
		if($id == null)
		{
			$id = $this->id; 
		}

		return $this->field('active', array('User.id' => $id)) == 1;
	}
}