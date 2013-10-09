<?php
class LegalsController extends AppController {
	public $helpers = array( 'Html', 'Form' );
	public $components = array( 'Session' );

	public function index() {
		$this->set( 'title_for_layout', __( 'Legal Constrains' ) );
		$this->set( 'subtitle_for_layout', __( 'Most businesses deal with Legal requirement, either from customers, providers, regulators, etc. Compliance to this requirements is a good idea. ' ) );

		$this->paginate = array(
			'conditions' => array(
			),
			'fields' => array(
				'Legal.id', 'Legal.name', 'Legal.description', 'Legal.risk_magnifier'
			),
			'order' => array('Legal.id' => 'ASC'),
			'limit' => $this->getPageLimit(),
			'recursive' => 0
		);

		$data = $this->paginate( 'Legal' );
		$this->set( 'data', $data );
	}

	public function delete( $id = null ) {
		$data = $this->Legal->find( 'count', array(
			'conditions' => array(
				'Legal.id' => $id
			)
		) );

		if ( empty( $data ) ) {
			throw new NotFoundException();
		}

		$this->Legal->delete( $id );

		$this->Session->setFlash( __( 'Legal was successfully deleted.' ), FLASH_OK );
		$this->redirect( array( 'controller' => 'legals', 'action' => 'index' ) );
	}

	public function add() {
		$this->set( 'title_for_layout', __( 'Add Legal' ) );
		$this->initAddEditSubtitle();
		
		if ( $this->request->is( 'post' ) ) {
			unset( $this->request->data['Legal']['id'] );

			$this->Legal->set( $this->request->data );

			if ( $this->Legal->validates() ) {
				if ( $this->Legal->save() ) {
					$this->Session->setFlash( __( 'Legal was successfully added.' ), FLASH_OK );
					$this->redirect( array( 'controller' => 'legals', 'action' => 'index' ) );
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
			$id = (int) $this->request->data['Legal']['id'];
		}

		$legal = $this->Legal->find( 'first', array(
			'conditions' => array(
				'Legal.id' => $id
			),
			'recursive' => -1
		) );

		if ( empty( $legal ) ) {
			throw new NotFoundException();
		}

		$this->set( 'edit', true );
		$this->set( 'title_for_layout', __( 'Edit Legal' ) );
		$this->initAddEditSubtitle();
		
		if ( $this->request->is( 'post' ) || $this->request->is( 'put' ) ) {

			$this->Legal->set( $this->request->data );

			if ( $this->Legal->validates() ) {
				if ( $this->Legal->save() ) {
					$this->Session->setFlash( __( 'Legal was successfully edited.' ), FLASH_OK );
					$this->redirect( array( 'controller' => 'legals', 'action' => 'index', $id ) );
				}
				else {
					$this->Session->setFlash( __( 'Error while saving the data. Please try it again.' ), FLASH_ERROR );
				}
			} else {
				$this->Session->setFlash( __( 'One or more inputs you entered are invalid. Please try again.' ), FLASH_ERROR );
			}
		}
		else {
			$this->request->data = $legal;
		}

		$this->render( 'add' );
	}

	private function initAddEditSubtitle() {
		$this->set( 'subtitle_for_layout', __( 'It\'s critical to understand the business potential liabilities and regulations to which is subject. In particular this is important at the time of managing a Business Continuity Management (BCM) program and Risk Management.' ) );
	}

}
?>