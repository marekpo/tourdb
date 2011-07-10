<div class="paginator">
<?php

	echo $this->Html->div('first', $this->Paginator->first(
		$this->Html->image('resultset_first.png', array(
			'alt' => __('« Erste Seite', true), 'title' => __('« Erste Seite', true)
		)),
		array('escape' => false)
	));

	echo $this->Html->div('prev', $this->Paginator->prev(
		$this->Html->image('resultset_previous.png', array(
			'alt' => __('« Zurück', true), 'title' => __('« Zurück', true)
		)),
		array('escape' => false), ' '
	));

	echo $this->Html->div('last', $this->Paginator->last(
		$this->Html->image('resultset_last.png', array(
			'alt' => __('Letzte Seite »', true), 'title' => __('Letzte Seite »', true)
		)),
		array('escape' => false)
	));

	echo $this->Html->div('next', $this->Paginator->next(
		$this->Html->image('resultset_next.png', array(
			'alt' => __('Weiter »', true), 'title' => __('Weiter »', true)
		)),
		array('escape' => false), ' '
	));

	echo $this->Html->div('numbers', $this->Paginator->numbers());

?>
<div style="clear: both"></div>
</div>