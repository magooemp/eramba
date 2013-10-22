<?php
class ServiceContractsController extends AppController {
	public $helpers = array( 'Html', 'Form' );
	public $components = array( 'Session' );

	public function index() {
		$this->set( 'title_for_layout', __( 'Service Contracts' ) );
		$this->set( 'subtitle_for_layout', __( 'Of particular importance for those Security Organizations with many controls and providers, keeping an inventory of support contracts is vital at the times of budget planning!' ) );

		$this->loadModel( 'ThirdParty' );
		$this->paginate = array(
			'conditions' => array(
			),
			'fields' => array(
				//'Legal.id', 'Legal.name', 'Legal.description', 'Legal.risk_magnifier'
			),
			'order' => array('ThirdParty.id' => 'ASC'),
			'limit' => $this->getPageLimit(),
			'recursive' => 1
		);

		$data = $this->paginate( 'ThirdParty' );
		$this->set( 'data', $data );
		//debug( $data );
	}

	public function delete( $id = null ) {
		$data = $this->ServiceContract->find( 'count', array(
			'conditions' => array(
				'Process.id' => $id
			)
		) );

		if ( empty( $data ) ) {
			throw new NotFoundException();
		}

		$this->ServiceContract->delete( $id );

		$this->Session->setFlash( __( 'Service Contract was successfully deleted.' ), FLASH_OK );
		$this->redirect( array( 'controller' => 'serviceContracts', 'action' => 'index' ) );
	}

	public function add( $tp_id = null ) {
		$tp_id = (int) $tp_id;

		$this->set( 'title_for_layout', __( 'Create a Service Contract' ) );
		$this->initAddEditSubtitle();
		
		if ( $this->request->is( 'post' ) ) {
			unset( $this->request->data['ServiceContract']['id'] );

			$this->ServiceContract->set( $this->request->data );

			if ( $this->ServiceContract->validates() ) {
				if ( $this->ServiceContract->save() ) {
					$this->Session->setFlash( __( 'Service Contract was successfully added.' ), FLASH_OK );
					$this->redirect( array( 'controller' => 'serviceContracts', 'action' => 'index' ) );
				} else {
					$this->Session->setFlash( __( 'Error while saving the data. Please try it again.' ), FLASH_ERROR );
				}
			} else {
				$this->Session->setFlash( __( 'One or more inputs you entered are invalid. Please try again.' ), FLASH_ERROR );
			}
		} else {
			$data = $this->ServiceContract->ThirdParty->find( 'first', array(
				'conditions' => array(
					'ThirdParty.id' => $tp_id
				),
				'recursive' => -1
			) );

			if ( empty( $data ) ) {
				throw new NotFoundException();
			}
		}

		$this->set( 'tp_id', $tp_id );
	}

	public function edit( $id = null ) {
		$id = (int) $id;

		if ( ! empty( $this->request->data ) ) {
			$id = (int) $this->request->data['ServiceContract']['id'];
		}

		$data = $this->ServiceContract->find( 'first', array(
			'conditions' => array(
				'ServiceContract.id' => $id
			),
			'recursive' => -1
		) );

		if ( empty( $data ) ) {
			throw new NotFoundException();
		}

		$this->set( 'edit', true );
		$this->set( 'title_for_layout', __( 'Edit a Service Contract' ) );
		$this->initAddEditSubtitle();
		
		if ( $this->request->is( 'post' ) || $this->request->is( 'put' ) ) {

			$this->ServiceContract->set( $this->request->data );

			if ( $this->ServiceContract->validates() ) {
				
				if ( $this->ServiceContract->save() ) {
					$this->Session->setFlash( __( 'Service Contract was successfully edited.' ), FLASH_OK );
					$this->redirect( array( 'controller' => 'serviceContracts', 'action' => 'index', $id ) );
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
		$this->set( 'subtitle_for_layout', __( 'Describe the support contracts you have with this providers. You can at a later stage, asociate this support contracts with security services as well.' ) );
	}

}