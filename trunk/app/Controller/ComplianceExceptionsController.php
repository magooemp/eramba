<?php
class ComplianceExceptionsController extends AppController {
	public $helpers = array( 'Html', 'Form' );
	public $components = array( 'Session' );

	public function index() {
		$this->set( 'title_for_layout', __( 'Compliance Exception Management' ) );
		$this->set( 'subtitle_for_layout', __( 'Sometimes compliance is not possible and Compliance Exceptions are required in order to assess the impact of non-compliance.' ) );

		$this->paginate = array(
			'conditions' => array(
			),
			'fields' => array(
				//'Legal.id', 'Legal.name', 'Legal.description', 'Legal.risk_magnifier'
			),
			'order' => array('ComplianceException.id' => 'ASC'),
			'limit' => $this->getPageLimit(),
			'recursive' => 0
		);

		$data = $this->paginate( 'ComplianceException' );
		$this->set( 'data', $data );
	}

	public function delete( $id = null ) {
		$data = $this->ComplianceException->find( 'count', array(
			'conditions' => array(
				'ComplianceException.id' => $id
			)
		) );

		if ( empty( $data ) ) {
			throw new NotFoundException();
		}

		$this->ComplianceException->delete( $id );

		$this->Session->setFlash( __( 'Compliance Exception was successfully deleted.' ), FLASH_OK );
		$this->redirect( array( 'controller' => 'complianceExceptions', 'action' => 'index' ) );
	}

	public function add() {
		$this->set( 'title_for_layout', __( 'Create a Compliance Exception' ) );
		$this->initAddEditSubtitle();
		
		if ( $this->request->is( 'post' ) ) {
			unset( $this->request->data['ComplianceException']['id'] );

			$this->ComplianceException->set( $this->request->data );

			if ( $this->ComplianceException->validates() ) {
				if ( $this->ComplianceException->save() ) {
					$this->Session->setFlash( __( 'Compliance Exception was successfully added.' ), FLASH_OK );
					$this->redirect( array( 'controller' => 'complianceExceptions', 'action' => 'index' ) );
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
			$id = (int) $this->request->data['ComplianceException']['id'];
		}

		$data = $this->ComplianceException->find( 'first', array(
			'conditions' => array(
				'ComplianceException.id' => $id
			),
			'recursive' => -1
		) );

		if ( empty( $data ) ) {
			throw new NotFoundException();
		}

		$this->set( 'edit', true );
		$this->set( 'title_for_layout', __( 'Edit a Compliance Exception' ) );
		$this->initAddEditSubtitle();
		
		if ( $this->request->is( 'post' ) || $this->request->is( 'put' ) ) {

			$this->ComplianceException->set( $this->request->data );

			if ( $this->ComplianceException->validates() ) {
				if ( $this->ComplianceException->save() ) {
					$this->Session->setFlash( __( 'Compliance Exception was successfully edited.' ), FLASH_OK );
					$this->redirect( array( 'controller' => 'complianceExceptions', 'action' => 'index', $id ) );
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
		$this->set( 'subtitle_for_layout', __( 'Compliance Exceptions are very usefull at the time of accepting a known non-compliancy. Once approved, they provide substantiation to Compliance items.' ) );
	}

}
?>