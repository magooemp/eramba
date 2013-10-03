<?php
class ThirdPartiesController extends AppController {
	public $helpers = array( 'Html', 'Form' );
	public $components = array( 'Session' );
	public $paginate = array(
		'limit' => 30
	);

	public function index() {
		$this->set( 'title_for_layout', __( 'Third Parties' ) );
		$this->set( 'subtitle_for_layout', __( 'Most organization partners and executes busineses with many other parties. Understanding this links is necesary in order to develop a full picture of hte scope of your security program. ' ) );

		$data = $this->paginate( 'ThirdParty' );
		$this->set( 'data', $data );
	}

	public function delete( $id = null ) {
		$data = $this->Legal->find( 'count', array(
			'conditions' => array(
				'Legal.legal_id' => $id
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
		$this->set( 'title_for_layout', __( 'Add Third Party' ) );
		$this->set( 'subtitle_for_layout', __( 'No bussiness operates alone. There\'s always customers (well, hopefully), providers, regulators, etc. It\'s important to define them clearly from the begining since we\'ll be using them in order to control support contracts, compliances, audits, etc.' ) );
		
		if ( $this->request->is( 'post' ) ) {
			unset( $this->request->data['ThirdParty']['id'] );

			$this->ThirdParty->set( $this->request->data );

			if ( $this->ThirdParty->validates() ) {
				if ( $this->ThirdParty->save() ) {
					$this->Session->setFlash( __( 'Third Party was successfully added.' ) );
					$this->redirect( array( 'controller' => 'thirdParties', 'action' => 'index' ) );
				}
			}
		}

		$types = $this->get_tp_types();

		$this->set( 'types', $types );
	}

	public function edit( $id = null ) {
		$id = (int) $id;

		if ( ! empty( $this->request->data ) ) {
			$id = (int) $this->request->data['ThirdParty']['tp_id'];
		}

		$tp = $this->ThirdParty->find( 'first', array(
			'conditions' => array(
				'ThirdParty.tp_id' => $id
			),
			'recursive' => -1
		) );

		if ( empty( $tp ) ) {
			throw new NotFoundException();
		}

		$this->set( 'edit', true );
		$this->set( 'title_for_layout', __( 'Edit Third Party' ) );
		
		if ( $this->request->is( 'post' ) || $this->request->is( 'put' ) ) {

			$this->ThirdParty->set( $this->request->data );

			if ( $this->ThirdParty->validates() ) {
				
				if ( $this->ThirdParty->save() ) {
					$this->Session->setFlash( __( 'Third Party was successfully edited.' ) );
					$this->redirect( array( 'controller' => 'legals', 'action' => 'index', $id ) );
				}
				else {
					$this->Session->setFlash( __( 'Error occured. Try again please.' ) );
				}
			}
		}
		else {
			$this->request->data = $tp;
		}

		$types = $this->get_tp_types();

		$this->set( 'types', $types );

		$this->render( 'add' );
	}

	private function get_tp_types() {
		$this->loadModel( 'ThirdPartiesType' );
		$tp_types = $this->ThirdPartiesType->find( 'all' );

		$types = array();
		foreach ( $tp_types as $type ) {
			$types[ $type['ThirdPartiesType']['tp_type_id'] ] = $type['ThirdPartiesType']['tp_type_name'];
		}

		return $types;
	}

}
?>