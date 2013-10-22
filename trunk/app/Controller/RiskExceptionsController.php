<?php
class RiskExceptionsController extends AppController {
	public $helpers = array( 'Html', 'Form' );
	public $components = array( 'Session' );

	public function index() {
		$this->set( 'title_for_layout', __( 'Risk Exception Management' ) );
		$this->set( 'subtitle_for_layout', __( 'Defining Risk Exceptions is one way to accept Risks when their mitigation is not viable.' ) );

		$this->paginate = array(
			'conditions' => array(
			),
			'fields' => array(
				//'Legal.id', 'Legal.name', 'Legal.description', 'Legal.risk_magnifier'
			),
			'order' => array('RiskException.id' => 'ASC'),
			'limit' => $this->getPageLimit(),
			'recursive' => 0
		);

		$data = $this->paginate( 'RiskException' );
		$this->set( 'data', $data );
	}

	public function delete( $id = null ) {
		$data = $this->RiskException->find( 'count', array(
			'conditions' => array(
				'RiskException.id' => $id
			)
		) );

		if ( empty( $data ) ) {
			throw new NotFoundException();
		}

		$this->RiskException->delete( $id );

		$this->Session->setFlash( __( 'Risk Exception was successfully deleted.' ), FLASH_OK );
		$this->redirect( array( 'controller' => 'riskExceptions', 'action' => 'index' ) );
	}

	public function add() {
		$this->set( 'title_for_layout', __( 'Create a Risk Exception' ) );
		$this->initAddEditSubtitle();
		
		if ( $this->request->is( 'post' ) ) {
			unset( $this->request->data['RiskException']['id'] );

			$this->RiskException->set( $this->request->data );

			if ( $this->RiskException->validates() ) {
				if ( $this->RiskException->save() ) {
					$this->Session->setFlash( __( 'Risk Exception was successfully added.' ), FLASH_OK );
					$this->redirect( array( 'controller' => 'riskExceptions', 'action' => 'index' ) );
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
			$id = (int) $this->request->data['RiskException']['id'];
		}

		$data = $this->RiskException->find( 'first', array(
			'conditions' => array(
				'RiskException.id' => $id
			),
			'recursive' => -1
		) );

		if ( empty( $data ) ) {
			throw new NotFoundException();
		}

		$this->set( 'edit', true );
		$this->set( 'title_for_layout', __( 'Edit a Risk Exception' ) );
		$this->initAddEditSubtitle();
		
		if ( $this->request->is( 'post' ) || $this->request->is( 'put' ) ) {

			$this->RiskException->set( $this->request->data );

			if ( $this->RiskException->validates() ) {
				if ( $this->RiskException->save() ) {
					$this->Session->setFlash( __( 'Risk Exception was successfully edited.' ), FLASH_OK );
					$this->redirect( array( 'controller' => 'riskExceptions', 'action' => 'index', $id ) );
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
		$this->set( 'subtitle_for_layout', __( 'Risk Exceptions are very usefull at the time of accepting a known risk. Once approved, they provide substantiation to Risk items.' ) );
	}

}
?>