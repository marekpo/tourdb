<?php
class TourGuideReportsController extends AppController
{
	var $name = 'TourGuideReports';

	var $helpers = array('Html', 'Form', 'Display', 'Excel', 'Time', 'TourDisplay' );

	/**
	 * @auth:Model.Tour.isTourGuideOf(#arg-0)
	 */
	function edit($tourId)
	{
		if(!empty($this->data))
		{
			$this->data['Tour']['id'] = $tourId;
			$this->data['TourGuideReport']['id'] = $this->TourGuideReport->field('id', array('TourGuideReport.tour_id' => $tourId));
			$this->data['TourGuideReport']['tour_id'] = $tourId;

			$this->TourGuideReport->Tour->setChangeDetail($this->Auth->user('id'), sprintf('%s:%s', Inflector::underscore($this->name), Inflector::underscore($this->action)));

			if($this->TourGuideReport->saveAll($this->data))
			{
				$this->Session->setFlash(__('Tourenrapport wurde gespeichert. Bitte exportieren und per E-Mail abschicken!', true));
				$this->redirect(array('controller' => 'tours', 'action' => 'view', $tourId));
			}
			else
			{
				$this->Session->setFlash(__('Fehler beim Speichern des Tourenrapports.', true));
			}
		}
		else
		{
			$this->data = $this->TourGuideReport->find('first', array(
				'conditions' => array('TourGuideReport.tour_id' => $tourId),
				'contain' => array('Tour.tour_status_id')
			));
		}

		$tour = $this->TourGuideReport->Tour->find('first', array(
			'conditions' => array('Tour.id' => $tourId),
			'contain' => array()
		));

		$reportStatusOptions = $this->TourGuideReport->getReportStatusOptions();
		$reportStatusDefault = $this->TourGuideReport->getReportStatusDefault();

		$tourStatuses = $reportStatusOptions;

		$this->set(compact('reportStatusOptions', 'reportStatusDefault', 'tour', 'tourStatuses'));
	}

	/**
	 * @auth:Model.Tour.isTourGuideOf(#arg-0)
	 */
	function exportTourguideReport($tourId)
	{
		if(!empty($this->data))
		{
			$tour = $this->TourGuideReport->Tour->find('first', array(
				'conditions' => array('Tour.id' => $tourId),
				'contain' => array(
					'TourGuideReport', 'TourGuide', 'TourGuide.Profile', 'TourGuide.Profile.SacMainSection', 'TourGroup'
				)
			));

			$tourParticipations = $this->TourGuideReport->Tour->TourParticipation->find('all', array(
				'conditions' => array('TourParticipation.tour_id' => $tourId, 'TourParticipationStatus.key' => 'affirmed'),
				'contain' => array(
					'User', 'User.Profile', 'User.Profile.SacMainSection','TourParticipationStatus'
				)
			));

			$this->viewPath = Inflector::underscore($this->name) . DS . 'xls';
			$this->set(array(
				'tour' => $tour,
				'tourParticipations' => $tourParticipations
			));
		}

		$this->data = $this->TourGuideReport->Tour->find('first', array(
			'fields' => array('Tour.id', 'Tour.title'),
			'conditions' => array('Tour.id' => $tourId),
			'contain' => array()
		));
	}	
}