<?php
$this->set('title_for_layout', __('Benutzer', true));
$this->Html->addCrumb(__('Benutzer', true));
?>
<div class="userFilter">
<?php
$this->Paginator->options(array('url' => array('?' => $this->data['User'])));

echo $this->Form->create(false, array('type' => 'GET', 'url' => $this->passedArgs));
echo $this->Form->input('User.username', array('label' => __('Benutzername', true)));
echo $this->Form->input('User.email', array('label' => __('E-Mail-Adresse', true)));
echo $this->Html->div('columncontainer',
	$this->Html->div('half',
				$this->Form->submit(__('Suchen', true), array('div' => array('class' => 'submit obtrusive')))
	)
	. $this->Html->div('half obtrusive links',
		$this->Html->link(__('Suchfilter zurücksetzen', true), array('controller' => $this->params['controller'], 'action' => $this->params['action']))
	)
);

echo $this->Form->end();

?>
</div>

<?php
$tableHeaders = array(
	$this->Paginator->sort(__('Aktiv', true), 'User.active'),
	$this->Paginator->sort(__('Benutzername', true), 'User.username'),
	$this->Paginator->sort(__('E-Mail-Adresse', true), 'User.email'),
	$this->Paginator->sort(__('Letzter Login', true), 'User.last_login'),
	__('Aktionen', true)
);

$userCells = array();
foreach($users as $user)
{
	$userCells[] = array(
		$this->Display->displayFlag($user['User']['active']),
		$user['User']['username'],
		$user['User']['email'],
		$user['User']['last_login'],
		$this->Html->link(__('Bearbeiten', true), array('action' => 'edit', $user['User']['id']))
	);
}

echo $this->Widget->table($tableHeaders, $userCells);

echo $this->element('paginator');