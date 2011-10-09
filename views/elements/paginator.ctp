<?php

if($this->Paginator->counter('%pages%') > 1)
{
	echo $this->Html->div('paginator',
		$this->Html->div('prev', $this->Paginator->prev('« Zurück', array('escape' => false), ' '))
		. $this->Html->div('numbers', $this->Paginator->numbers())
		. $this->Html->div('next', $this->Paginator->next('Weiter »', array('escape' => false), ' '))
	);
}