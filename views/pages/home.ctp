<?php $this->set('title_for_layout', __('Tourenangebot', true)); ?>

<h2>Wilkommen in Tourenangebot der SAC Sektion Am Albis!</h2>

<?php

if(!$this->Session->check('Auth.User'))
{
	echo $this->Html->para('', 'Um weiterzumachen logge dich bitte ein.');
}