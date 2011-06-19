<?php
class WidgetHelper extends AppHelper
{
	var $helpers = array('Html', 'Js');

	function dragDrop($name, $options = array())
	{
		if(isset($options['itemClass']))
		{
			$itemClass = $options['itemClass'];
			unset($options['itemClass']);
		}
		else
		{
			$itemClass = Inflector::underscore($name);
		}

		if(!isset($options['options']))
		{
			$view =& ClassRegistry::getObject('view');
			$varName = Inflector::variable(Inflector::pluralize($name));
			$options['options'] = $view->getVar($varName);
		}

		$attributes = $this->_initInputField($name, array('type' => 'hidden'));

		$value = $attributes['value'];
		unset($attributes['value']); 

		$forUniqueId = Inflector::underscore($name);

		$ddWidget = $this->Html->tag('input', '', $attributes);

		$availableItems = '';
		foreach($options['options'] as $key => $label)
		{
			if(!in_array($key, $value))
			{
				$availableItems .= $this->__createItem($key, $label, $itemClass);
			}
		}
		$ddWidget .= $this->Html->div('dd-all', $availableItems, array('id' => sprintf('all-items-%s', $forUniqueId)));

		$associatedItems = '';
		$associatedItemsInputs = '';
		foreach($value as $key)
		{
			$associatedItems .= $this->__createItem($key, $options['options'][$key], $itemClass);
			$associatedItemsInputs .= $this->Html->tag('input', '', array('type' => 'hidden', 'name' => sprintf('%s[]', $attributes['name']), 'value' => $key));
		}

		$ddWidget .= $this->Html->div('dd-assoc', $associatedItems, array('id' => sprintf('assoc-items-%s', $forUniqueId)));
		$ddWidget .= $this->Html->div('', $associatedItemsInputs, array('id' => sprintf('assoc-items-inputs-%s', $forUniqueId), 'style' => 'display:none'));

		$ddWidget .= $this->Html->div('', '', array('style' => 'clear: both'));

		$ddWidget = $this->Html->div('dd-container', $ddWidget, array('id' => sprintf('dd-%s', $forUniqueId)));

		$this->Html->script('widgets/dragdrop', array('inline' => false));

		$this->Js->get(sprintf('#all-items-%s', $forUniqueId));
		$this->Js->drop(array(
			'accept' => sprintf('#assoc-items-%s > .item', $forUniqueId),
			'drop' => sprintf('TourDB_DragDrop.removeItem(ui.draggable, \'%s\');', $forUniqueId),
			'activeClass' => 'active',
			'hoverClass' => 'hover'
		));
		
		$this->Js->get(sprintf('#assoc-items-%s', $forUniqueId));
		$this->Js->drop(array(
			'accept' => sprintf('#all-items-%s > .item', $forUniqueId),
			'drop' => sprintf('TourDB_DragDrop.addItem(ui.draggable, \'%s\', \'%s\');', $forUniqueId, $attributes['name']),
			'activeClass' => 'active',
			'hoverClass' => 'hover'
		));
		
		$this->Js->get(sprintf('#dd-%s .item', $forUniqueId));
		$this->Js->drag(array('revert' => 'invalid', 'helper' => 'clone'));
		
		return $ddWidget;
	}

	function __createItem($key, $label, $itemClass)
	{
		return $this->Html->div(sprintf('item %s', $itemClass), $label, array('id' => sprintf('item-%s', $key)));
	}
}