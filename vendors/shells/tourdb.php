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
	var $uses = array('User');

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

		$response = $this->in(sprintf('This will import all the users in %s into the database. Continue?', $importFile), array('y', 'n'), 'n');

		if($response == 'n')
		{
			$this->_stop();
		}

		$importedCount = 0;
		$errorCount = 0;
		$errorFile = null;

		while($row = fgetcsv($importFile, 0, ';'))
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

			$this->User->create();
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
		fclose($errorFile);
	}
}