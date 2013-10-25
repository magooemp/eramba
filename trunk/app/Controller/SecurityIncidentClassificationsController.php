<?php
class SecurityIncidentClassificationsController extends AppController {
	public $helpers = array( 'Html', 'Form' );
	public $components = array( 'Session' );

	public function index() {
		$this->set( 'title_for_layout', __( 'Security Incident Classification Scheme' ) );
		$this->set( 'subtitle_for_layout', __( 'Define how you would like Security Incidents to be classied at the time of creating them.' ) );

		$this->paginate = array(
			'conditions' => array(
			),
			'fields' => array(
				'SecurityIncidentClassification.id',
				'SecurityIncidentClassification.name',
				'SecurityIncidentClassification.criteria'
			),
			'order' => array('SecurityIncidentClassification.id' => 'ASC'),
			'limit' => $this->getPageLimit(),
			'recursive' => 0
		);

		$data = $this->paginate( 'SecurityIncidentClassification' );
		$this->set( 'data', $data );
	}

	public function delete( $id = null ) {
		$data = $this->SecurityIncidentClassification->find( 'count', array(
			'conditions' => array(
				'SecurityIncidentClassification.id' => $id
			)
		) );

		if ( empty( $data ) ) {
			throw new NotFoundException();
		}

		$this->SecurityIncidentClassification->delete( $id );

		$this->Session->setFlash( __( 'Security Incident Classification was successfully deleted.' ), FLASH_OK );
		$this->redirect( array( 'controller' => 'securityIncidentClassifications', 'action' => 'index' ) );
	}

	public function add() {
		$this->set( 'title_for_layout', __( 'Create a Security Incident Classification' ) );
		$this->initAddEditSubtitle();
		
		if ( $this->request->is( 'post' ) ) {
			unset( $this->request->data['SecurityIncidentClassification']['id'] );

			$this->SecurityIncidentClassification->set( $this->request->data );

			if ( $this->SecurityIncidentClassification->validates() ) {
				if ( $this->SecurityIncidentClassification->save() ) {
					$this->Session->setFlash( __( 'Security Incident Classification was successfully added.' ), FLASH_OK );
					$this->redirect( array( 'controller' => 'securityIncidentClassifications', 'action' => 'index' ) );
				} else {
					$this->Session->setFlash( __( 'Error while saving the data. Please try it again.' ), FLASH_ERROR );
				}
			} else {
				$this->Session->setFlash( __( 'One or more inputs you entered are invalid. Please try again.' ), FLASH_ERROR );
			}
		}
	}

	public function edit( $id = null ) {
		$id = (int) $id;

		if ( ! empty( $this->request->data ) ) {
			$id = (int) $this->request->data['SecurityIncidentClassification']['id'];
		}

		$data = $this->SecurityIncidentClassification->find( 'first', array(
			'conditions' => array(
				'SecurityIncidentClassification.id' => $id
			),
			'recursive' => -1
		) );

		if ( empty( $data ) ) {
			throw new NotFoundException();
		}

		$this->set( 'edit', true );
		$this->set( 'title_for_layout', __( 'Edit a Security Incident Classification' ) );
		$this->initAddEditSubtitle();
		
		if ( $this->request->is( 'post' ) || $this->request->is( 'put' ) ) {

			$this->SecurityIncidentClassification->set( $this->request->data );

			if ( $this->SecurityIncidentClassification->validates() ) {
				if ( $this->SecurityIncidentClassification->save() ) {
					$this->Session->setFlash( __( 'Security Incident Classification was successfully edited.' ), FLASH_OK );
					$this->redirect( array( 'controller' => 'securityIncidentClassifications', 'action' => 'index', $id ) );
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

		$this->render( 'add' );
	}

	private function initAddEditSubtitle() {
		$this->set( 'subtitle_for_layout', __( 'Define your Security Incident Classification.' ) );
	}

}
?>