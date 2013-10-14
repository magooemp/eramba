<?php
class ThirdPartiesController extends AppController {
	public $helpers = array( 'Html', 'Form' );
	public $components = array( 'Session' );

	public function index() {
		$this->set( 'title_for_layout', __( 'Third Parties' ) );
		$this->set( 'subtitle_for_layout', __( 'Most organization partners and executes busineses with many other parties. Understanding this links is necesary in order to develop a full picture of hte scope of your security program.' ) );

		$this->paginate = array(
			'conditions' => array(
			),
			'fields' => array(
				'ThirdParty.id',
				'ThirdParty.name',
				'ThirdParty.description',
				'ThirdPartyType.name'
			),
			'order' => array( 'ThirdParty.id' => 'ASC' ),
			'limit' => $this->getPageLimit(),
			'recursive' => 0
		);

		$data = $this->paginate( 'ThirdParty' );
		$this->set( 'data', $data );

	}

	public function delete( $id = null ) {
		$data = $this->ThirdParty->find( 'count', array(
			'conditions' => array(
				'ThirdParty.id' => $id
			)
		) );

		if ( empty( $data ) ) {
			throw new NotFoundException();
		}

		$this->ThirdParty->delete( $id );

		$this->Session->setFlash( __( 'Third Party was successfully deleted.', FLASH_OK ) );
		$this->redirect( array( 'controller' => 'thirdParties', 'action' => 'index' ) );
	}

	public function add() {
		$this->set( 'title_for_layout', __( 'Create a Third Party' ) );
		$this->initAddEditSubtitle();
		
		if ( $this->request->is( 'post' ) ) {
			unset( $this->request->data['ThirdParty']['id'] );

			$this->ThirdParty->set( $this->request->data );

			if ( $this->ThirdParty->validates() ) {
				if ( $this->ThirdParty->save() ) {
					$this->Session->setFlash( __( 'Third Party was successfully added.' ), FLASH_OK );
					$this->redirect( array( 'controller' => 'thirdParties', 'action' => 'index' ) );
				} else {
					$this->Session->setFlash( __( 'Error while saving the data. Please try it again.', FLASH_ERROR ) );
				}
			} else {
				$this->Session->setFlash( __( 'One or more inputs you entered are invalid. Please try again.' ), FLASH_ERROR );
			}
		}

		$this->initTpTypes();
	}

	public function edit( $id = null ) {
		$id = (int) $id;

		if ( ! empty( $this->request->data ) ) {
			$id = (int) $this->request->data['ThirdParty']['id'];
		}

		$tp = $this->ThirdParty->find( 'first', array(
			'conditions' => array(
				'ThirdParty.id' => $id
			),
			'recursive' => -1
		) );

		if ( empty( $tp ) ) {
			throw new NotFoundException();
		}

		$this->set( 'edit', true );
		$this->set( 'title_for_layout', __( 'Edit a Third Party' ) );
		$this->initAddEditSubtitle();
		
		if ( $this->request->is( 'post' ) || $this->request->is( 'put' ) ) {

			$this->ThirdParty->set( $this->request->data );

			if ( $this->ThirdParty->validates() ) {
				
				if ( $this->ThirdParty->save() ) {
					$this->Session->setFlash( __( 'Third Party was successfully edited.' ), FLASH_OK );
					$this->redirect( array( 'controller' => 'thirdParties', 'action' => 'index', $id ) );
				}
				else {
					$this->Session->setFlash( __( 'Error while saving the data. Please try it again.' ), FLASH_ERROR );
				}
			} else {
				$this->Session->setFlash( __( 'One or more inputs you entered are invalid. Please try again.' ), FLASH_ERROR );
			}
		}
		else {
			$this->request->data = $tp;
		}

		$this->initTpTypes();

		$this->render( 'add' );
	}

	private function initTpTypes() {
		$tp_types = $this->ThirdParty->ThirdPartyType->find('list', array(
			'order' => array('ThirdPartyType.name' => 'ASC'),
			'recursive' => -1
		));
		
		$this->set( 'tp_types', $tp_types );
	}

	private function initAddEditSubtitle() {
		$this->set( 'subtitle_for_layout', __( 'No bussiness operates alone. There\'s always customers (well, hopefully), providers, regulators, etc. It\'s important to define them clearly from the begining since we\'ll be using them in order to control support contracts, compliances, audits, etc.' ) );
	}

}
?>