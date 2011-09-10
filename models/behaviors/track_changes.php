<?php
class TrackChangesBehavior extends ModelBehavior
{
	function setup(&$model, $settings = array())
	{
		$this->settings[$model->alias] = array_merge(array(
			'fields' => array()
		), $settings);

		$model->bindModel(array(
			'hasMany' => array(
				'ModelChange' => array(
					'foreignKey' => 'record_id',
					'conditions' => array('modelname' => $model->alias),
					'order' => array('created' => 'ASC')
				)
			)), false
		);
	}

	function setChangeDetail(&$model, $userId, $changeContext)
	{
		$model->changingUserId = $userId;
		$model->changeContext = $changeContext;
	}

	function beforeSave(&$model)
	{
		extract($this->settings[$model->alias]);

		if(!empty($model->id) && !empty($fields))
		{
			if(!isset($model->changingUserId) || empty($model->changingUserId) || !isset($model->changeContext) || empty($model->changeContext))
			{
				trigger_error(sprintf(__('Model %s is using the TrackChangesBehavior, but is missing required change information. Use the setChangeDetail() method on the model prior to calling save.', true), $model->alias), E_USER_WARNING);
				return false;
			}

			$recordBeforeSave = $this->__getTrackedFieldValues($model);

			$this->settings[$model->alias]['valuesBeforeSave'] = array();

			foreach($fields as $field)
			{
				$this->settings[$model->alias]['valuesBeforeSave'][$field] = $recordBeforeSave[$model->alias][$field];
			}
		}

		return true;
	}

	function afterSave(&$model, $created)
	{
		extract($this->settings[$model->alias]);

		if(!$created && !empty($fields))
		{
			$recordAfterChange = $this->__getTrackedFieldValues($model);

			$modelChangeDetails = array('ModelChangeDetail' => array());

			foreach($fields as $field)
			{
				if($recordAfterChange[$model->alias][$field] != $valuesBeforeSave[$field])
				{
					$modelChangeDetails['ModelChangeDetail'][] = array(
						'fieldname' => $field,
						'oldvalue' => $valuesBeforeSave[$field],
						'newvalue' => $recordAfterChange[$model->alias][$field]
					);
				}
			}

			if(!empty($modelChangeDetails))
			{
				$modelChange = array_merge(array(
					'ModelChange' => array(
						'record_id' => $model->id,
						'modelname' => $model->alias,
						'user_id' => $model->changingUserId,
						'context' => $model->changeContext
					)
				), $modelChangeDetails);

				$model->ModelChange->create();
				$model->ModelChange->saveAll($modelChange);
			}
		}
	}

	function __getTrackedFieldValues(&$model)
	{
		return $model->find('first', array(
			'conditions' => array('id' => $model->id),
			'fields' => $this->settings[$model->alias]['fields'],
			'contain' => array()
		));
	}
}