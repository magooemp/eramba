<?php
class ServiceClassificationsController extends AppController {
	public $helpers = array( 'Html', 'Form' );
	public $components = array( 'Session' );

	public function index() {
		$this->set( 'title_for_layout', __( 'Security Services Classification Scheme' ) );
		$this->set( 'subtitle_for_layout', __( 'Define how you would like Security Services to be classied at the time of creating them.' ) );

		$this->paginate = array(
			'conditions' => array(
			),
			'fields' => array(
				//'Legal.id', 'Legal.name', 'Legal.description', 'Legal.risk_magnifier'
			),
			'order' => array('ServiceClassification.id' => 'ASC'),
			'limit' => $this->getPageLimit(),
			'recursive' => 0
		);

		$data = $this->paginate( 'ServiceClassification' );
		$this->set( 'data', $data );
	}

	public function delete( $id = null ) {
		$data = $this->ServiceClassification->find( 'count', array(
			'conditions' => array(
				'ServiceClassification.id' => $id
			)
		) );

		if ( empty( $data ) ) {
			throw new NotFoundException();
		}

		if ( $this->ServiceClassification->delete( $id ) ) {
			$this->Session->setFlash( __( 'Service Classification was successfully deleted.' ), FLASH_OK );
		} else {
			$this->Session->setFlash( __( 'Error while deleting the data. Please try it again.' ), FLASH_ERROR );
		}

		$this->redirect( array( 'controller' => 'serviceClassifications', 'action' => 'index' ) );
	}

	public function add() {
		$this->set( 'title_for_layout', __( 'Create a Security Service Classification' ) );
		$this->initAddEditSubtitle();
		
		if ( $this->request->is( 'post' ) ) {
			unset( $this->request->data['ServiceClassification']['id'] );

			$this->ServiceClassification->set( $this->request->data );

			if ( $this->ServiceClassification->validates() ) {
				if ( $this->ServiceClassification->save() ) {
					$this->Session->setFlash( __( 'Service Classification was successfully added.' ), FLASH_OK );
					$this->redirect( array( 'controller' => 'serviceClassifications', 'action' => 'index' ) );
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
			$id = (int) $this->request->data['ServiceClassification']['id'];
		}

		$data = $this->ServiceClassification->find( 'first', array(
			'conditions' => array(
				'ServiceClassification.id' => $id
			),
			'recursive' => -1
		) );

		if ( empty( $data ) ) {
			throw new NotFoundException();
		}

		$this->set( 'edit', true );
		$this->set( 'title_for_layout', __( 'Edit a Security Service Classification' ) );
		$this->initAddEditSubtitle();
		
		if ( $this->request->is( 'post' ) || $this->request->is( 'put' ) ) {

			$this->ServiceClassification->set( $this->request->data );

			if ( $this->ServiceClassification->validates() ) {
				if ( $this->ServiceClassification->save() ) {
					$this->Session->setFlash( __( 'Service Classification was successfully edited.' ), FLASH_OK );
					$this->redirect( array( 'controller' => 'serviceClassifications', 'action' => 'index', $id ) );
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