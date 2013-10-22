<?php
class SecurityServicesController extends AppController {
	public $helpers = array( 'Html', 'Form' );
	public $components = array( 'Session' );

	public function index() {
		$this->set( 'title_for_layout', __( 'Security Services Catalogue' ) );
		$this->set( 'subtitle_for_layout', __( 'If Security Controls are one of the main deliverables of a Security Organization, it\'s highgly recommended to keep them well identified.' ) );

		$this->paginate = array(
			'conditions' => array(
			),
			'fields' => array(
				//'Legal.id', 'Legal.name', 'Legal.description', 'Legal.risk_magnifier'
			),
			'order' => array('SecurityService.id' => 'ASC'),
			'limit' => $this->getPageLimit(),
			'recursive' => 0
		);

		$data = $this->paginate( 'SecurityService' );
		$this->set( 'data', $data );
	}

	public function delete( $id = null ) {
		$data = $this->SecurityService->find( 'count', array(
			'conditions' => array(
				'SecurityService.id' => $id
			)
		) );

		if ( empty( $data ) ) {
			throw new NotFoundException();
		}

		$this->SecurityService->delete( $id );

		$this->Session->setFlash( __( 'Security Service was successfully deleted.' ), FLASH_OK );
		$this->redirect( array( 'controller' => 'securityServices', 'action' => 'index' ) );
	}

	public function add() {
		$this->set( 'title_for_layout', __( 'Create a Security Service' ) );
		$this->initAddEditSubtitle();
		
		if ( $this->request->is( 'post' ) ) {
			unset( $this->request->data['SecurityService']['id'] );

			$this->SecurityService->set( $this->request->data );

			if ( $this->SecurityService->validates() ) {
				if ( $this->SecurityService->save() ) {
					$this->joinServicesContracts( $this->request->data['SecurityService']['service_contract_id'], $this->SecurityService->id );

					$this->Session->setFlash( __( 'Security Service was successfully added.' ), FLASH_OK );
					$this->redirect( array( 'controller' => 'securityServices', 'action' => 'index' ) );
				} else {
					$this->Session->setFlash( __( 'Error while saving the data. Please try it again.' ), FLASH_ERROR );
				}
			} else {
				$this->Session->setFlash( __( 'One or more inputs you entered are invalid. Please try again.' ), FLASH_ERROR );
			}
		}

		$this->initOptions();
	}

	public function edit( $id = null ) {
		$id = (int) $id;

		if ( ! empty( $this->request->data ) ) {
			$id = (int) $this->request->data['SecurityService']['id'];
		}

		$data = $this->SecurityService->find( 'first', array(
			'conditions' => array(
				'SecurityService.id' => $id
			),
			'recursive' => 1
		) );

		if ( empty( $data ) ) {
			throw new NotFoundException();
		}
		
		$this->set( 'edit', true );
		$this->set( 'title_for_layout', __( 'Edit a Security Service' ) );
		$this->initAddEditSubtitle();
		
		if ( $this->request->is( 'post' ) || $this->request->is( 'put' ) ) {

			$this->SecurityService->set( $this->request->data );

			if ( $this->SecurityService->validates() ) {
				if ( $this->SecurityService->save() ) {
					$this->SecurityService->SecurityServicesServiceContract->deleteAll( array(
						'SecurityServicesServiceContract.security_service_id' => $id
					) );

					$this->joinServicesContracts( $this->request->data['SecurityService']['service_contract_id'], $this->SecurityService->id );

					$this->Session->setFlash( __( 'Security Service was successfully edited.' ), FLASH_OK );
					$this->redirect( array( 'controller' => 'securityServices', 'action' => 'index', $id ) );
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

		$this->initOptions();
		$this->render( 'add' );
	}

	private function joinServicesContracts( $contracts_list, $service_id ) {
		foreach ( $contracts_list as $id ) {
			$tmp = array(
				'security_service_id' => $service_id,
				'service_contract_id' => $id
			);

			$this->SecurityService->SecurityServicesServiceContract->create();
			$this->SecurityService->SecurityServicesServiceContract->save( $tmp );
		}
	}

	private function initOptions() {
		$types = $this->SecurityService->SecurityServiceType->find('list', array(
			'order' => array('SecurityServiceType.name' => 'ASC'),
			'recursive' => -1
		));

		$classifications = $this->SecurityService->ServiceClassification->find('list', array(
			'order' => array('ServiceClassification.name' => 'ASC'),
			'recursive' => -1
		));

		$contracts = $this->SecurityService->ServiceContract->find('list', array(
			'order' => array('ServiceContract.name' => 'ASC'),
			'recursive' => -1
		));

		$this->set( 'types', $types );
		$this->set( 'classifications', $classifications );
		$this->set( 'contracts', $contracts );
	}

	private function initAddEditSubtitle() {
		$this->set( 'subtitle_for_layout', __( 'Pretty much the same way a restaurant has a menu, a security program has a menu of services and even sometimes products. It\'s very important to know what security services your program has, since it\'s the core of it\'s delivery and must be well understood and managed.' ) );
	}

}
?>