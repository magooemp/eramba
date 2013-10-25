<?php
class SecurityIncidentsController extends AppController {
	public $helpers = array( 'Html', 'Form' );
	public $components = array( 'Session' );

	public function index() {
		$this->set( 'title_for_layout', __( 'Security Incidents' ) );
		$this->set( 'subtitle_for_layout', __( 'Records for all reported Security Incidents.' ) );

		$this->paginate = array(
			'conditions' => array(
			),
			'fields' => array(
				//'Legal.id', 'Legal.name', 'Legal.description', 'Legal.risk_magnifier'
			),
			'order' => array('SecurityIncident.id' => 'ASC'),
			'limit' => $this->getPageLimit(),
			'recursive' => 0
		);

		$data = $this->paginate( 'SecurityIncident' );
		$this->set( 'data', $data );
	}

	public function delete( $id = null ) {
		$data = $this->SecurityIncident->find( 'count', array(
			'conditions' => array(
				'SecurityIncident.id' => $id
			)
		) );

		if ( empty( $data ) ) {
			throw new NotFoundException();
		}

		$this->SecurityIncident->delete( $id );
		$this->deleteJoins( $id );

		$this->Session->setFlash( __( 'Security Incident was successfully deleted.' ), FLASH_OK );
		$this->redirect( array( 'controller' => 'securityIncidents', 'action' => 'index' ) );
	}

	public function add() {
		$this->set( 'title_for_layout', __( 'Create a Security Incident' ) );
		$this->initAddEditSubtitle();
		
		if ( $this->request->is( 'post' ) ) {
			unset( $this->request->data['SecurityIncident']['id'] );

			$this->SecurityIncident->set( $this->request->data );

			if ( $this->SecurityIncident->validates() ) {
				if ( $this->SecurityIncident->save() ) {
					$this->joinSecurityServices( $this->request->data['SecurityIncident']['security_service_id'], $this->SecurityIncident->id );

					$this->Session->setFlash( __( 'Security Incident was successfully added.' ), FLASH_OK );
					$this->redirect( array( 'controller' => 'securityIncidents', 'action' => 'index' ) );
				} else {
					$this->Session->setFlash( __( 'Error while saving the data. Please try it again.' ), FLASH_ERROR );
				}
			} else {
				$this->Session->setFlash( __( 'One or more inputs you entered are invalid. Please try again.' ), FLASH_ERROR );
			}
		}

		$this->initOptions();
	}

	public function edit( $id = null ) {
		$id = (int) $id;

		if ( ! empty( $this->request->data ) ) {
			$id = (int) $this->request->data['SecurityIncident']['id'];
		}

		$data = $this->SecurityIncident->find( 'first', array(
			'conditions' => array(
				'SecurityIncident.id' => $id
			),
			'recursive' => 1
		) );

		if ( empty( $data ) ) {
			throw new NotFoundException();
		}

		$this->set( 'edit', true );
		$this->set( 'title_for_layout', __( 'Edit a Security Incident' ) );
		$this->initAddEditSubtitle();
		
		if ( $this->request->is( 'post' ) || $this->request->is( 'put' ) ) {

			$this->SecurityIncident->set( $this->request->data );

			if ( $this->SecurityIncident->validates() ) {
				if ( $this->SecurityIncident->save() ) {
					$this->deleteJoins( $id );
					$this->joinSecurityServices( $this->request->data['SecurityIncident']['security_service_id'], $this->SecurityIncident->id );

					$this->Session->setFlash( __( 'Security Incident was successfully edited.' ), FLASH_OK );
					$this->redirect( array( 'controller' => 'securityIncidents', 'action' => 'index', $id ) );
				}
				else {
					$this->Session->setFlash( __( 'Error while saving the data. Please try it again.' ), FLASH_ERROR );
				}
			} else {
				$this->Session->setFlash( __( 'One or more inputs you entered are invalid. Please try again.' ), FLASH_ERROR );
			}
		}
		else {
			$this->request->data = $data;
		}

		$this->initOptions();

		$this->render( 'add' );
	}

	private function joinSecurityServices( $list, $incident_id ) {
		foreach ( $list as $id ) {
			$tmp = array(
				'security_incident_id' => $incident_id,
				'security_service_id' => $id
			);

			$this->SecurityIncident->SecurityIncidentsSecurityService->create();
			$this->SecurityIncident->SecurityIncidentsSecurityService->save( $tmp );
		}
	}

	/**
	 * Delete all many to many joins in related tables.
	 * @param  integer $id Risk ID
	 */
	private function deleteJoins( $id ) {
		$this->SecurityIncident->SecurityIncidentsSecurityService->deleteAll( array(
			'SecurityIncidentsSecurityService.security_incident_id' => $id
		) );
	}

	/**
	 * Initialize options for join elements.
	 */
	private function initOptions() {
		$statuses = $this->SecurityIncident->SecurityIncidentStatus->find('list', array(
			'order' => array('SecurityIncidentStatus.name' => 'ASC'),
			'recursive' => -1
		));

		$third_parties = $this->SecurityIncident->ThirdParty->find('list', array(
			'order' => array('ThirdParty.name' => 'ASC'),
			'recursive' => -1
		));

		$classifications = $this->SecurityIncident->SecurityIncidentClassification->find('list', array(
			'order' => array('SecurityIncidentClassification.name' => 'ASC'),
			'recursive' => -1
		));

		$assets = $this->SecurityIncident->Asset->find('list', array(
			'order' => array('Asset.name' => 'ASC'),
			'recursive' => -1
		));

		$services = $this->SecurityIncident->SecurityService->find('list', array(
			'order' => array('SecurityService.name' => 'ASC'),
			'recursive' => -1
		));

		$this->set( 'statuses', $statuses );
		$this->set( 'third_parties', $third_parties );
		$this->set( 'classifications', $classifications );
		$this->set( 'assets', $assets );
		$this->set( 'services', $services );
	}

	private function initAddEditSubtitle() {
		$this->set( 'subtitle_for_layout', __( 'It\'s critical to understand the business potential liabilities and regulations to which is subject. In particular this is important at the time of managing a Business Continuity Management (BCM) program and Risk Management.' ) );
	}

}
?>