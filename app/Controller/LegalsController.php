<?php
class LegalsController extends AppController {
	public $helpers = array( 'Html', 'Form' );
	public $components = array( 'Session' );
	public $paginate = array(
		'limit' => 20
	);

	public function index() {
		$this->set( 'title_for_layout', __( 'Legal Constrains' ) );
		$this->set( 'subtitle_for_layout', __( 'Most businesses deal with Legal requirement, either from customers, providers, regulators, etc. Compliance to this requirements is a good idea. ' ) );

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

		$this->Session->setFlash( __( 'Legal was successfully deleted.' ) );
		$this->redirect( array( 'controller' => 'legals', 'action' => 'index' ) );
	}

	public function add() {
		$this->set( 'title_for_layout', __( 'Add Legal' ) );
		$this->set( 'subtitle_for_layout', __( 'It\'s critical to understand the business potential liabilities and regulations to which is subject. In particular this is important at the time of managing a Business Continuity Management (BCM) program and Risk Management.' ) );
		
		if ( $this->request->is( 'post' ) ) {
			unset( $this->request->data['Legal']['id'] );

			$this->Legal->set( $this->request->data );

			if ( $this->Legal->validates() ) {
				if ( $this->Legal->save() ) {
					$this->Session->setFlash( __( 'Legal was successfully added.' ) );
					$this->redirect( array( 'controller' => 'legals', 'action' => 'index' ) );
				}
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
		
		if ( $this->request->is( 'post' ) || $this->request->is( 'put' ) ) {

			$this->Legal->set( $this->request->data );

			if ( $this->Legal->validates() ) {
				
				if ( $this->Legal->save() ) {
					$this->Session->setFlash( __( 'Legal was successfully edited.' ) );
					$this->redirect( array( 'controller' => 'legals', 'action' => 'index', $id ) );
				}
				else {
					$this->Session->setFlash( __( 'Error occured. Try again please.' ) );
				}
			}
		}
		else {
			$this->request->data = $legal;
		}

		$this->render( 'add' );
	}

}
?>