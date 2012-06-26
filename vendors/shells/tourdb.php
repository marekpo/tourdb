<?php
if(!class_exists('SecurityTools'))
{
	App::import('Lib', 'SecurityTools');
}

if(!class_exists('Security'))
{
	App::import('Lib', 'Security');
}

class TourDBShell extends Shell
{
	var $uses = array('User', 'Role', 'Tour', 'TourStatus');

	function main()
	{
		$this->out('test');
	}

	function importusers()
	{
		if(count($this->args) < 1)
		{
			$this->error('No import file specified');
		}

		if(($importFilePath = realpath($this->args[0])) === false)
		{
			$this->error('Specified import file could not be found.');
		}

		if(($importFile = fopen($importFilePath, 'r')) === false)
		{
			$this->error(sprintf('Import file %s could not be opened for reading.', $importFilePath));
		}

		$securityQuery = sprintf('This will import all the users in %s into the database. ', $importFilePath);

		if(!empty($this->params['promoteToTourGuide']))
		{
			$securityQuery .= 'All imported users will be promoted to tour guides. ';
		}

		$response = $this->in(sprintf('%sContinue?', $securityQuery), array('y', 'n'), 'n');

		if($response !== 'y')
		{
			$this->_stop();
		}

		$importedCount = 0;
		$errorCount = 0;
		$errorFile = null;
		$tourGuideRoleId = $this->Role->field('id', array('Role.key' => Role::TOURLEADER));

		while($row = fgetcsv($importFile, 0, ';'))
		{
			$existingUser = $this->User->find('first', array(
				'fields' => array('User.id'),
				'conditions' => array(
					'OR' => array(
						array('User.username' => $row[0]),
						array('User.email' => $row[2])
					)
				),
				'contain' => array('Role.id')
			));

			if(!empty($existingUser))
			{
				$user = $existingUser;
				$user['Role'] = array(
					'Role' => Set::extract('/Role/id', $user)
				);
			}
			else
			{
				$salt = SecurityTools::generateRandomString();

				$user = array(
					'User' => array(
						'username' => $row[0],
						'salt' => $salt,
						'password' => $this->User->hashPassword($salt, $row[1]),
						'email' => $row[2]
					)
				);
			}

			if(!empty($this->params['promoteToTourGuide']))
			{
				$user['Role']['Role'][] = $tourGuideRoleId;
			}

			$this->User->create();
			unset($this->User->data['User']['dataprivacystatementaccepted']);
			if(!$this->User->save($user))
			{
				$errorCount++;

				if($errorFile === null)
				{
					$errorFilePath = dirname($importFilePath) . DS . substr_replace(basename($importFilePath), '_error.', strrpos(basename($importFilePath), '.'), 1);
					if(($errorFile = fopen($errorFilePath, 'w')) == false)
					{
						$this->out(sprintf('Could not open error file %s for writing.', $errorFilePath));
					}
				}

				if($errorFile !== false)
				{
					$errorColumn = array();
					foreach($this->User->validationErrors as $field => $rule)
					{
						$errorColumn[] = sprintf('%s => %s', $field, $rule);
					}

					$row[] = implode(',', $errorColumn);
					fwrite($errorFile, sprintf("%s\n", implode(';', $row)));
				}

				continue;
			}

			$this->User->activateAccount($this->User->getLastInsertID(), $row[1], $row[1], $row[1]);

			$importedCount++;
		}

		$this->out('Done.');
		$this->out(sprintf('Imported %d users. There were %d errors.', $importedCount, $errorCount));

		if($errorCount > 0 && $errorFile !== null && $errorFile !== false)
		{
			$this->out(sprintf('Errors have been written to %s.', $errorFilePath));
		}

		fclose($importFile);

		if($errorFile != null)
		{
			fclose($errorFile);
		}
	}

	function settourstatus()
	{
		$this->out('This will update the status of all tours to the status you specified.');
		$response = $this->in(sprintf('Are you sure, you want to continue?'), array('y', 'n'), 'n');

		if($response == 'n')
		{
			$this->_stop();
		}

		$newStatusKey = $this->in('Enter the new status for all tours:', array('fixed', 'published'), 'fixed');

		$newStatus = $this->TourStatus->find('first', array(
			'conditions' => array('key' => $newStatusKey)
		));

		if(empty($newStatus))
		{
			$this->out(sprintf('No TourStatus record was found for key "%s".', $newStatusKey));
			$this->_stop();
		}

		$response = $this->in(sprintf('This will set the status of all Tours to "%s". Continue?', $newStatus['TourStatus']['statusname']), array('y', 'n'), 'n');

		if($response == 'n')
		{
			$this->_stop();
		}

		$superuser = $this->User->find('first', array(
			'conditions' => array('username' => 'superadmin')
		));

		$allTours = $this->Tour->find('all', array(
			'fields' => array('id'),
			'contain' => array()
		));

		foreach($allTours as $tour)
		{
			$this->Tour->create();
			$this->Tour->setChangeDetail($superuser['User']['id'], 'Batch change via command line');
			$this->Tour->save(array(
				'Tour' => array(
					'id' => $tour['Tour']['id'],
					'tour_status_id' => $newStatus['TourStatus']['id']
				)
			));
		}
	}
}