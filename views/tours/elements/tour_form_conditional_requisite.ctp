<?php
echo $this->Html->div(sprintf('input select required%s', (isset($this->validationErrors['Tour']['ConditionalRequisite']) ? ' error' : '')));
echo $this->Form->label('Tour.ConditionalRequisite', __('Anforderung', true));
echo $this->Form->hidden('Tour.ConditionalRequisite', array('value' => ''));

$value = $this->Form->value(array(), 'Tour.ConditionalRequisite');

foreach($conditionalRequisites as $conditionalRequisite)
{
	echo $this->Html->div('checkbox',
		$this->Form->checkbox('Tour.ConditionalRequisite', array(
			'id' => sprintf('TourConditionalRequisite%s', $conditionalRequisite['ConditionalRequisite']['id']),
			'name' => 'data[Tour][ConditionalRequisite][]', 'label' => $conditionalRequisite['ConditionalRequisite']['acronym'],
			'hiddenField' => false, 'value' => $conditionalRequisite['ConditionalRequisite']['id'],
			'checked' => !empty($value['value']) && in_array($conditionalRequisite['ConditionalRequisite']['id'], $value['value']),
			'disabled' => isset($whitelist) && !in_array('ConditionalRequisite', $whitelist)
		))
		. $this->Html->tag('label', $conditionalRequisite['ConditionalRequisite']['acronym'], array(
			'for' => sprintf('TourConditionalRequisite%s', $conditionalRequisite['ConditionalRequisite']['id'])
		))
	, array('title' => $conditionalRequisite['ConditionalRequisite']['description']));
}

echo $this->Html->div('', '', array('style' => 'clear: left'));
echo $this->Form->error('Tour.ConditionalRequisite', array(
	'rightQuanitity' => __('Es müssen mindestens ein und maximal zwei Anforderungen gewählt werden.', true)
));
echo '</div>';