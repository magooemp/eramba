<?php
class BusinessUnitsController extends AppController {
	public $helpers = array( 'Html', 'Form' );
	public $components = array( 'Session' );

	public function index() {
		$this->set( 'title_for_layout', __( 'Business Units' ) );
		$this->set( 'subtitle_for_layout', __( 'Describing the organiational units and their main processes is a basic component on any Security Program. After all it might be a good idea to know what is that you are protecting! ' ) );

		$this->paginate = array(
			'conditions' => array(
			),
			'contain' => array(
				'Process' => array(
					'fields' => array( 'id', 'name', 'description', 'rto' )
				)
			),
			'fields' => array(
				'BusinessUnit.id',
				'BusinessUnit.name'
			),
			'order' => array( 'BusinessUnit.id' => 'ASC' ),
			'limit' => $this->getPageLimit(),
			'recursive' => 1
		);

		$data = $this->paginate( 'BusinessUnit' );
		$this->set( 'data', $data );
	}

	public function add() {
		$this->set( 'title_for_layout', __( 'Add Business Unit' ) );
		$this->initAddEditSubtitle();
		
		if ( $this->request->is( 'post' ) ) {
			unset( $this->request->data['BusinessUnit']['id'] );

			$this->BusinessUnit->set( $this->request->data );

			if ( $this->BusinessUnit->validates() ) {
				if ( $this->BusinessUnit->save() ) {
					$this->Session->setFlash( __( 'Business Unit was successfully added.' ), FLASH_OK );
					$this->redirect( array( 'controller' => 'businessUnits', 'action' => 'index' ) );
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
			$id = (int) $this->request->data['BusinessUnit']['id'];
		}

		$data = $this->BusinessUnit->find( 'first', array(
			'conditions' => array(
				'BusinessUnit.id' => $id
			),
			'recursive' => -1
		) );

		if ( empty( $data ) ) {
			throw new NotFoundException();
		}

		$this->set( 'edit', true );
		$this->set( 'title_for_layout', __( 'Edit Business Unit' ) );
		$this->initAddEditSubtitle();
		
		if ( $this->request->is( 'post' ) || $this->request->is( 'put' ) ) {

			$this->BusinessUnit->set( $this->request->data );

			if ( $this->BusinessUnit->validates() ) {
				
				if ( $this->BusinessUnit->save() ) {
					$this->Session->setFlash( __( 'Business Unit was successfully edited.' ), FLASH_OK );
					$this->redirect( array( 'controller' => 'businessUnits', 'action' => 'index', $id ) );
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
		$this->set( 'subtitle_for_layout', __( 'This is the very first step to split your organization in to manageable bits for later analysis.' ) );
	}

}