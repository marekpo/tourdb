<?php
class TourGuideReportsController extends AppController
{
	var $name = 'TourGuideReports';

	var $helpers = array('Html', 'Form', 'Display', 'Widget');

	/**
	 * @auth:allowed()
	 */
	function edit($tourId = NULL)
	{
		
		if(!empty($this->data))
		{
			
			$this->data['TourGuideReport']['tour_id'] = $this->data['Tour']['id'];

			if($this->TourGuideReport->save($this->data))
			{
				$this->Session->setFlash(__('Tourenrapport wurde gespeichert. Jetzt kannst du ihm exportieren', true));
				$this->redirect(array('controller' => 'Tours', 'action' => 'view', $this->data['Tour']['id']));
			}
			else {
				
				$this->Session->setFlash(__('Fehler beim Speichern des Tourenrapports.', true));
			}
		}

		$this->data = $this->TourGuideReport->Tour->find('first', array('conditions' => array('Tour.id' => $tourId),
				'contain' => array('TourGuideReport')
		));
		
	}	

}