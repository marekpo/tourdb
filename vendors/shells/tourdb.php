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

	var $tasks = array('Email');

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

		$promoteToTourGuide = !empty($this->params['promoteToTourGuide']);
		$securityQuery = sprintf('This will import all the users in %s into the database. ', $importFilePath);

		if($promoteToTourGuide)
		{
			$securityQuery .= 'All imported users will be promoted to tour guides. ';
		}

		$response = $this->in(sprintf('%sContinue?', $securityQuery), array('y', 'n'), 'n');

		if($response !== 'y')
		{
			$this->_stop();
		}

		$importedCount = 0;
		$skippedCount = 0;
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
				if(!$promoteToTourGuide)
				{
					$skippedCount++;

					continue;
				}

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

			if($promoteToTourGuide)
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
		$this->out(sprintf('Imported %d users, skipped %d. There were %d errors.', $importedCount, $skippedCount, $errorCount));

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

	function sendTourChangesNotifications()
	{
		$this->out('This will send notification E-Mails when Tours was changed in last days.');

		if(empty($this->params['reviewDays']))
		{
			$reviewDays = 1;
		}
		else
		{
			$reviewDays = $this->params['reviewDays'];

			if(is_numeric($reviewDays))
			{
				if($reviewDays == 0)
				{
					$reviewDays = 1;
				}
			}
			else
			{
				$this->error(sprintf('-reviewDays %s must be number greater or equal 1!', $reviewDays ));
				$this->_stop();
			}
		}

		if(empty($this->params['baseUrl']))
		{
			$this->error('Missing parameter -baseUrl.');
			$this->_stop();
		}
		else
		{
			$baseUrl = $this->params['baseUrl'];

			if(!defined('FULL_BASE_URL'))
			{
				define('FULL_BASE_URL', $baseUrl);
			}
		}

		$dateFromQuery = date('Y-m-d', strtotime(sprintf('-%s day', $reviewDays)));
		$dateToQuery = date('Y-m-d', strtotime(sprintf('now', $reviewDays)));

		$dateFromText = date('d.m.Y', strtotime(sprintf('-%s day', $reviewDays)));
		$dateToText = date('d.m.Y', strtotime(sprintf('now', $reviewDays)));

		$tourStatusEditable = $this->Tour->TourStatus->find('all', array(
			'fields' => array('TourStatus.id'),
			'conditions' => array('TourStatus.key' => array(TourStatus::NEW_, TourStatus::FIXED)),
			'contain' => array()
		));

		$tours = $this->Tour->find('all', array(
			'conditions' => array(
				'Tour.modified >=' => $dateFromQuery,
				'Tour.modified <' => $dateToQuery,
				'Tour.tour_status_id' => Set::extract('/TourStatus/id', $tourStatusEditable)
			)
		));

		$this->out('SET ReviewDays = ' . $reviewDays );
		$this->out('SET DateFrom = ' . $dateFromText );
		$this->out('SET DateTo = ' . $dateToText );

		if(empty($tours))
		{
			$this->out('No new or changed tours found. No notifications will be sent.');
			$this->_stop();
		}

		$recipients = implode(',', Set::extract('/User/email', $this->User->getUsersByRole(Role::EDITOR)));

		$this->out('SET Recipiens = ' . $recipients);
		$this->out(sprintf('Sending notifications about %d new or changed tours.', count($tours)));

		$subject = sprintf('Tourenangebot: geänderte Touren von: %s bis: %s', $dateFromText, $dateToText) ;

		App::import('Core', 'Router');

		$this->Email->sendEmail($recipients, $subject, 'notify_tour_changes', $tours);
	}
}