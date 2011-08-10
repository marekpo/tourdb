<?php
App::import('Lib', 'SecurityTools');

class User extends AppModel
{
	var $name = 'User';

	var $displayField = 'username';

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
		),
		'changedPasswordRepeat' => array(
			'mismatch' => array(
				'rule' => array('identicalFields', 'changedPassword')
			)
		)
	);

	var $hasAndBelongsToMany = array('Role');

	function correctTempPassword($field)
	{
		$value = array_pop($field);

		$passwordData = $this->findById($this->data['User']['id'], array('User.salt', 'User.password'));

		return $this->hashPassword($passwordData['User']['salt'], $value) == $passwordData['User']['password'];
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
			$data['User']['password'] = $this->hashPassword($salt, $data['User']['password']);

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
		$this->data['User']['password'] = $this->hashPassword($salt, $password);

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

		$userData = array(
			'User' => array(
				'id' => $id,
				'salt' => $salt,
				'password' => $this->hashPassword($salt, $newPassword),
				'active' => 1
			)
		);
		
		$roles = $this->getRoles($id);
		$userRole = Set::extract(sprintf('/Role[key=%s]', Role::USER), $roles);

		if(count($userRole) == 0)
		{
			$userRole = $this->Role->find('first', array(
				'conditions' => array('Role.key' => Role::USER),
				'fields' => array('Role.id')
			));

			$userData = array_merge($userData, array(
				'Role' => array_merge(Set::extract('/Role/id', $roles), array(
					$userRole['Role']['id']
				))
			));
		}

		$this->create();
		return $this->save($userData);
	}

	function generateNewPassword($id)
	{
		$this->id = $id;

		$salt = SecurityTools::generateRandomString();
		$password = SecurityTools::generateRandomString(8);

		$this->data['User']['salt'] = $salt;
		$this->data['User']['password'] = $this->hashPassword($salt, $password);
		$this->data['User']['new_password_token'] = null;

		if($this->save())
		{
			return $password;
		}

		return false;
	}

	function hashPassword($salt, $password)
	{
		return Security::hash($salt . $password, 'sha1', false);
	}

	function updateLastLoginTime($id)
	{
		$this->id = $id;
		$this->saveField('last_login', date('Y-m-d H:i:s'));
	}

	function isActive($id = null)
	{
		if($id == null)
		{
			$id = $this->id; 
		}

		return $this->field('active', array('User.id' => $id)) == 1;
	}

	function getRoles($id = null)
	{
		if($id == null)
		{
			$id = $this->id;
		}

		$this->recursive = -1;
		$dbo = $this->getDataSource();

		$roles = $this->find('all', array(
			'conditions' => array('User.id' => $id),
			'fields' => array('Role.id', 'Role.rolename', 'Role.key', 'Role.rank'),
			'joins' => array(
				array(
					'table' => $dbo->fullTableName('roles_users'),
					'alias' => 'UsersRoles',
					'type' => 'inner',
					'conditions' => array('User.id = UsersRoles.user_id')
				),
				array(
					'table' => $dbo->fullTableName('roles'),
					'alias' => 'Role',
					'type' => 'left',
					'conditions' => array('Role.id = UsersRoles.role_id')
				)
			)
		));

		return $roles;
	}

	function getPrivileges($id = null)
	{
		if($id == null)
		{
			$id = $this->id; 
		}

		$this->recursive = -1;
		$dbo = $this->getDataSource();

		$privileges = $this->find('all', array(
			'conditions' => array('User.id' => $id),
			'fields' => array('DISTINCT Privilege.id', 'Privilege.key', 'Privilege.label'),
			'joins' => array(
				array(
					'table' => $dbo->fullTableName('roles_users'),
					'alias' => 'UsersRoles',
					'type' => 'inner',
					'conditions' => array('User.id = UsersRoles.user_id')
				),
				array(
					'table' => $dbo->fullTableName('privileges_roles'),
					'alias' => 'RolesPrivileges',
					'type' => 'inner',
					'conditions' => array('UsersRoles.role_id = RolesPrivileges.role_id')
				),
				array(
					'table' => $dbo->fullTableName('privileges'),
					'alias' => 'Privilege',
					'type' => 'left',
					'conditions' => array('Privilege.id = RolesPrivileges.privilege_id')
				)
			)
		));

		return $privileges;
	}
}