<div class="paginator">
<?php

	echo $this->Html->div('prev', $this->Paginator->prev('« Zurück', array('escape' => false), ' '));

	echo $this->Html->div('numbers', $this->Paginator->numbers());

	echo $this->Html->div('next', $this->Paginator->next('Weiter »', array('escape' => false), ' '));

?>
  <div style="clear: both"></div>
</div>