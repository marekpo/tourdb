<?php
class Tour extends AppModel
{
	const WIDGET_TOUR_GROUP = 'WIDGET_TOUR_GROUP';
	const WIDGET_TOUR_STATUS = 'WIDGET_TOUR_STATUS';
	const WIDGET_TOUR_GUIDE = 'WIDGET_TOUR_GUIDE';
	const WIDGET_TOUR_TYPE = 'WIDGET_TOUR_TYPE';
	const WIDGET_CONDITIONAL_REQUISITE = 'WIDGET_CONDITIONAL_REQUISITE';
	const WIDGET_DIFFICULTY = 'WIDGET_DIFFICULTY';

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
		),
		'deadline' => array(
			'lessThanStartDate' => array(
				'rule' => array('compareToDateField', '<', 'startdate'),
				'allowEmpty' => true
			)
		)
	);

	var $belongsTo = array(
		'TourGuide' => array(
			'className' => 'User'
		),
		'TourStatus',
		'TourGroup'
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

	function beforeValidate($options = array())
	{
		if(isset($this->data['Tour']['TourType']) && !empty($this->data['Tour']['TourType']))
		{
			$isCourse = $this->TourType->find('count', array(
				'conditions' => array(
					'TourType.id' => $this->data['Tour']['TourType'],
					'TourType.key' => TourType::TRAINING_COURSE
				),
				'contain' => array()
			)) > 0;

			if($isCourse)
			{
				unset($this->validate['ConditionalRequisite']);
			}
		}

		return true;
	}

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

		if(isset($this->data['Tour']['deadline']))
		{
			$this->data['Tour']['deadline'] = empty($this->data['Tour']['deadline']) ? null : date('Y-m-d', strtotime($this->data['Tour']['deadline']));
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

	function beforeDelete($cascade = true)
	{
		return $this->find('count', array(
			'conditions' => array(
				'Tour.id' => $this->id,
				'TourStatus.key' => TourStatus::NEW_
			),
			'contain' => array('TourStatus')
		)) == 1;
	}

	function afterFind($results, $primary = false)
	{
		if($primary)
		{
			foreach($results as $index => $tour)
			{
				if(!isset($tour['Tour']))
				{
					continue;
				}

				$results[$index]['Tour']['deadline_calculated'] = $this->__calculateDeadline($tour['Tour']);
			}
		}
		else
		{
			$results['deadline_calculated'] = $this->__calculateDeadline($results);
		}	

		return $results;
	}

	function isTourGuideOfRule($userId, $tourId)
	{
		return $this->find('count', array(
			'conditions' => array('Tour.id' => $tourId, 'Tour.tour_guide_id' => $userId)
		)) > 0;
	}

	function searchTours($searchFilters = array(), $additionalConditions = array())
	{
		$searchConditions = array();

		$this->unbindModel(array(
			'hasMany' => array('TourParticipation', 'ModelChange'),
			'hasAndBelongsToMany' => array('TourType', 'ConditionalRequisite', 'Difficulty')
		));

		if(isset($searchFilters['deadline']) && !empty($searchFilters['deadline']))
		{
			$searchConditions[] = array(
			'Tour.startdate >=' => date('Y-m-d', strtotime('+1 day'))
			/*
				'OR' => array(
					array('Tour.deadline' => null, 'Tour.startdate >=' => date('Y-m-d', strtotime('+1 day'))),
					array('Tour.deadline >=' => $searchFilters['deadline'])
				)
			*/	
			);
		}

		if(isset($searchFilters['title']) && !empty($searchFilters['title']))
		{
			$searchConditions['Tour.title LIKE'] = sprintf('%%%s%%', $searchFilters['title']);
		}

		if(isset($searchFilters['TourGroup']) && !empty($searchFilters['TourGroup']))
		{
			$searchConditions['Tour.tour_group_id'] = $searchFilters['TourGroup'];
		}

		if(isset($searchFilters['TourStatus']) && !empty($searchFilters['TourStatus']))
		{
			$searchConditions['Tour.tour_status_id'] = $searchFilters['TourStatus'];
		}

		if(isset($searchFilters['startdate']) && !empty($searchFilters['startdate']))
		{
			$searchConditions['Tour.startdate >='] = date('Y-m-d', strtotime($searchFilters['startdate']));
		}

		if(isset($searchFilters['enddate']) && !empty($searchFilters['enddate']))
		{
			$searchConditions['Tour.enddate <='] = date('Y-m-d', strtotime($searchFilters['enddate']));
		}

		if(isset($searchFilters['TourGuide']) && !empty($searchFilters['TourGuide']))
		{
			$searchConditions['Tour.tour_guide_id'] = $searchFilters['TourGuide'];
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
			'conditions' => array_merge($searchConditions, $additionalConditions)
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

		foreach($editEverythingWhitelist as $key => $value)
		{
			if($value == 'tour_group_id')
			{
				unset($editEverythingWhitelist[$key]);
				break;
			}
		}

		$tourStatus = $this->find('first', array(
			'fields' => array('TourStatus.rank', 'TourStatus.key'),
			'conditions' => array('Tour.id' => $id),
			'contain' => array('TourStatus')
		));

		$fixedTourStatus = $this->TourStatus->findByKey(TourStatus::FIXED);

		if($tourStatus['TourStatus']['rank'] < $fixedTourStatus['TourStatus']['rank'])
		{
			return $editEverythingWhitelist;
		}
		elseif($tourStatus['TourStatus']['key'] == TourStatus::FIXED)
		{
			return array('description', 'deadline', 'tour_status_id');
		}
		elseif($tourStatus['TourStatus']['key'] == TourStatus::PUBLISHED)
		{
			return array('tour_status_id');
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

	function isRegistrationOpen($id = null)
	{
		if(empty($this->data) || $id != null)
		{
			$this->id = $id;
			$this->read();
		}

		return strtotime($this->data['Tour']['deadline_calculated']) >= strtotime(date('Y-m-d'))
			&& $this->data['TourStatus']['key'] == TourStatus::PUBLISHED;
	}

	function setEditableByTourGuide($tours)
	{
		foreach($tours as $key => $tour)
		{
			if(!isset($tour['TourStatus']))
			{
				continue;
			}

			$tours[$key]['Tour']['editablebytourguide'] = in_array($tour['TourStatus']['key'], array(TourStatus::NEW_, TourStatus::FIXED));
		}

		return $tours;
	}

	function getWidgetData($widgets = array())
	{
		$widgetData = array();

		foreach($widgets as $widget)
		{
			$methodName = sprintf('__getDataFor%s', Inflector::camelize(strtolower($widget)));

			if(method_exists($this, $methodName))
			{
				$widgetData = array_merge($widgetData, $this->{$methodName}());
			}
		}

		return $widgetData;
	}

	function __calculateDeadline($tour)
	{
		if(array_key_exists('deadline', $tour))
		{
			if($tour['deadline'] != null)
			{
				return $tour['deadline'];
			}

			$startdate = isset($tour['startdate']) ? $tour['startdate'] : $this->field('startdate', array('id' => $tour['id']));

			return date('Y-m-d', strtotime('-1 day', strtotime($startdate)));
		}
	}

	function __getDataForWidgetTourGroup()
	{
		return array(
			'tourGroups' => $this->TourGroup->find('list', array(
				'order' => array('TourGroup.rank' => 'ASC')
			))
		);
	}

	function __getDataForWidgetTourStatus()
	{
		return array(
			'tourStatuses' => $this->TourStatus->find('list', array(
				'conditions' => array('TourStatus.key' => array(
					TourStatus::PUBLISHED, TourStatus::REGISTRATION_CLOSED, TourStatus::CANCELED, TourStatus::CARRIED_OUT)
				),
				'order' => array('TourStatus.rank' => 'ASC')
			))
		);
	}

	function __getDataForWidgetTourGuide()
	{
		return array(
			'tourGuides' => $this->TourGuide->getUsersByRole(Role::TOURLEADER, array(
				'contain' => array('Profile'),
				'order' => array('Profile.lastname' => 'ASC')
			)),
		);
	}

	function __getDataForWidgetTourType()
	{
		return array(
			'tourTypes' => $this->TourType->find('list', array(
				'fields' => array('acronym')
			)),
		);
	}

	function __getDataForWidgetConditionalRequisite()
	{
		return array(
 			'conditionalRequisites' => $this->ConditionalRequisite->find('list', array(
				'fields' => array('acronym'),
				'order' => array('acronym' => 'ASC')
			))
		);
	}

	function __getDataForWidgetDifficulty()
	{
		return array(
			'difficultiesSkiAndAlpineTour' => $this->Difficulty->find('list', array(
				'conditions' => array('group' => Difficulty::SKI_AND_ALPINE_TOUR),
				'order' => array('rank' => 'ASC'),
			)),
			'difficultiesAlpineTour' => $this->Difficulty->find('list', array(
				'conditions' => array('group' => Difficulty::ALPINE_TOUR),
				'order' => array('rank' => 'ASC')
			)),
			'difficultiesHike' => $this->Difficulty->find('list', array(
				'conditions' => array('group' => Difficulty::HIKE),
				'order' => array('rank' => 'ASC'),
			)),
			'difficultiesSnowshowTour' => $this->Difficulty->find('list', array(
				'conditions' => array('group' => Difficulty::SNOWSHOE_TOUR),
				'order' => array('rank' => 'ASC'),
			)),
			'difficultiesViaFerrata' => $this->Difficulty->find('list', array(
				'conditions' => array('group' => Difficulty::VIA_FERRATA),
				'order' => array('rank' => 'ASC'),
			)),
			'difficultiesRockClimbing' => $this->Difficulty->find('list', array(
				'conditions' => array('group' => Difficulty::ROCK_CLIMBING),
				'order' => array('rank' => 'ASC'),
			)),
			'difficultiesIceClimbing' => $this->Difficulty->find('list', array(
				'conditions' => array('group' => Difficulty::ICE_CLIMBING),
				'order' => array('rank' => 'ASC')
			))
		);
	}
}