<div class="userFilter">
<?php
if(!isset($activeFilters))
{
	$activeFilters = array();
}

$this->Paginator->options(array('url' => array('?' => $this->data['User'])));

echo $this->Form->create(false, array('type' => 'GET', 'url' => $this->passedArgs));

if(in_array('username', $activeFilters))
{
	echo $this->Form->input('User.username', array('label' => __('Benutzername', true)));
}

if(in_array('email', $activeFilters))
{
	echo $this->Form->input('User.email', array('label' => __('E-Mail-Adresse', true)));
}

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