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
		'password' => array(
			'empty' => array(
				'rule' => 'notEmpty'
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

	function hashPasswords($data)
	{
		if(isset($data['User']['username']) && isset($data['User']['password']))
		{
			$salt = $this->field('salt', array('User.username' => $data['User']['username']));
			$data['User']['password'] = Security::hash($salt . $data['User']['password'], 'sha1', false);

			return $data;
		}

		return $data;
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