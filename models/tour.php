<?php
class Tour extends AppModel
{
	var $name = 'Tour';

	var $actsAs = array(
		'Calendar',
		'TrackChanges' => array(
			'fields' => array('tour_status_id')
		)
	);

	var $validate = array(
		'title' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty' 
			)
		),
		'TourType' => array(
			'rightQuanitity' => array(
				'rule' => array('multiple', array('min' => 1, 'max' => 2))
			)
		),
		'ConditionalRequisite' => array(
			'rightQuanitity' => array(
				'rule' => array('multiple', array('min' => 1, 'max' => 2))
			)
		),
		'Difficulty' => array(
			'atMostTwo' => array(
				'rule' => array('multiple', array('min' => 1, 'max' => 2)),
				'allowEmpty' => true
			)
		),
		'startdate' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty'
			)
		),
		'enddate' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty'
			),
			'greaterOrEqualStartDate' => array(
				'rule' => array('compareToDateField', '>=', 'startdate')
			)
		)
	);

	var $belongsTo = array(
		'TourGuide' => array(
			'className' => 'User'
		),
		'TourStatus'
	);

	var $hasMany = array(
		'TourParticipation'
	);

	var $hasAndBelongsToMany = array(
		'TourType',
		'ConditionalRequisite' => array(
			'order' => array('acronym' => 'ASC')
		),
		'Difficulty' => array(
			'order' => array('group' => 'ASC', 'rank' => 'ASC')
		)
	);

	function beforeSave($options = array())
	{
		if(isset($this->data['Tour']['startdate']))
		{
			$this->data['Tour']['startdate'] = date('Y-m-d', strtotime($this->data['Tour']['startdate']));
		}

		if(isset($this->data['Tour']['enddate']))
		{
			$this->data['Tour']['enddate'] = date('Y-m-d', strtotime($this->data['Tour']['enddate']));
		}

		if(in_array('TourType', $options['fieldList']) && isset($this->data['Tour']['TourType']))
		{
			$this->data['TourType'] = $this->data['Tour']['TourType'];
		}
		unset($this->data['Tour']['TourType']);
		
		if(in_array('ConditionalRequisite', $options['fieldList']) && isset($this->data['Tour']['ConditionalRequisite']))
		{
			$this->data['ConditionalRequisite'] = $this->data['Tour']['ConditionalRequisite'];
		}
		unset($this->data['Tour']['ConditionalRequisite']);
		
		if(in_array('Difficulty', $options['fieldList']) && isset($this->data['Tour']['Difficulty']))
		{
			$this->data['Difficulty'] = $this->data['Tour']['Difficulty'];
		}
		unset($this->data['Tour']['Difficulty']);

		if(empty($this->id) && empty($this->data['Tour']['id']) && empty($this->data['Tour']['tour_status_id']))
		{
			$this->data['Tour']['tour_status_id'] = $this->TourStatus->field('id', array('key' => TourStatus::NEW_));
		}

		return true;
	}

	function searchTours($searchFilters = array())
	{
		$searchConditions = array();

		$this->unbindModel(array(
			'belongsTo' => array('TourGuide'),
			'hasMany' => array('TourParticipation'),
			'hasAndBelongsToMany' => array('TourType', 'ConditionalRequisite', 'Difficulty')
		));

		if(isset($searchFilters['query']) && !empty($searchFilters['query']))
		{
			$searchConditions['Tour.title LIKE'] = sprintf('%%%s%%', $searchFilters['query']);
		}

		if(isset($searchFilters['startdate']) && !empty($searchFilters['startdate']))
		{
			$searchConditions['Tour.startdate >='] = date('Y-m-d', strtotime($searchFilters['startdate']));
		}

		if(isset($searchFilters['enddate']) && !empty($searchFilters['enddate']))
		{
			$searchConditions['Tour.enddate <='] = date('Y-m-d', strtotime($searchFilters['enddate']));
		}

		if(isset($searchFilters['TourType']) && !empty($searchFilters['TourType']))
		{
			$this->bindModel(array(
				'hasOne' => array(
					'TourTypesTour' => array(
						'foreignKey' => false,
						'type' => 'INNER',
						'conditions' => array(
							'TourTypesTour.tour_id = Tour.id',
							array('TourTypesTour.tour_type_id' => $searchFilters['TourType'])
						)
					)
				)
			));
		}

		if(isset($searchFilters['ConditionalRequisite']) && !empty($searchFilters['ConditionalRequisite']))
		{
			$this->bindModel(array(
				'hasOne' => array(
					'ConditionalRequisitesTour' => array(
						'foreignKey' => false,
						'type' => 'INNER',
						'conditions' => array(
							'ConditionalRequisitesTour.tour_id = Tour.id',
							array('ConditionalRequisitesTour.conditional_requisite_id' => $searchFilters['ConditionalRequisite'])
						)
					)
				)
			));
		}

		if(isset($searchFilters['Difficulty']) && !empty($searchFilters['Difficulty']))
		{
			$this->bindModel(array(
				'hasOne' => array(
					'DifficultiesTour' => array(
						'foreignKey' => false,
						'type' => 'INNER',
						'conditions' => array(
							'DifficultiesTour.tour_id = Tour.id',
							array('DifficultiesTour.difficulty_id' => $searchFilters['Difficulty'])
						)
					)
				)
			));
		}

		return $this->find('all', array(
			'fields' => array('Tour.id'),
			'conditions' => array_merge($searchConditions, array('TourStatus.key' => array(TourStatus::FIXED, TourStatus::PUBLISHED, TourStatus::REGISTRATION_CLOSED, TourStatus::CANCELED))),
		));
	}

	function getEditWhitelist($id = null)
	{
		if($id == null)
		{
			$id = $this->id;
		}

		$editEverythingWhitelist = array_merge(
			array_keys($this->schema()),
			array(
				'TourType',
				'ConditionalRequisite',
				'Difficulty'
			)
		);

		if($id == null)
		{
			return $editEverythingWhitelist;
		}

		$tourStatus = $this->find('first', array(
			'fields' => array('TourStatus.rank'),
			'conditions' => array('Tour.id' => $id),
			'contain' => array('TourStatus')
		));

		$fixedTourStatus = $this->TourStatus->findByKey(TourStatus::FIXED);

		if($tourStatus['TourStatus']['rank'] < $fixedTourStatus['TourStatus']['rank'])
		{
			return $editEverythingWhitelist;
		}
		elseif($tourStatus['TourStatus']['rank'] == $fixedTourStatus['TourStatus']['rank'])
		{
			return array('description', 'tour_status_id');
		}
		else
		{
			return array();
		}
	}

	function getNewStatusOptions($roles = array())
	{
		if(!is_array($roles))
		{
			$roles = array($roles);
		}

		$newStatusOptions = array();

		if(in_array(Role::TOURCHIEF, $roles))
		{
			$newStatusOptions[TourStatus::NEW_] = __('neu', true);
			$newStatusOptions[TourStatus::FIXED] = __('fixiert', true);
		}

		if(in_array(Role::EDITOR, $roles))
		{
			$newStatusOptions[TourStatus::PUBLISHED] = __('veröffentlicht', true);
		}

		return $newStatusOptions;
	}
}