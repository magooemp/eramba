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

		if ( $this->SecurityService->delete( $id ) ) {
			$this->Session->setFlash( __( 'Security Service was successfully deleted.' ), FLASH_OK );
		} else {
			$this->Session->setFlash( __( 'Error while deleting the data. Please try it again.' ), FLASH_ERROR );
		}
		
		$this->redirect( array( 'controller' => 'securityServices', 'action' => 'index' ) );
	}

	public function add() {
		$this->set( 'title_for_layout', __( 'Create a Security Service' ) );
		$this->initAddEditSubtitle();
		
		if ( $this->request->is( 'post' ) ) {
			unset( $this->request->data['SecurityService']['id'] );

			$this->SecurityService->set( $this->request->data );

			if ( $this->SecurityService->validates() ) {
				$this->SecurityService->query( 'SET autocommit = 0' );
				$this->SecurityService->begin();

				$save1 = $this->SecurityService->save();
				$save2 = $this->joinServicesContracts( $this->request->data['SecurityService']['service_contract_id'], $this->SecurityService->id );
				$save3 = $this->joinSecurityPolicies( $this->request->data['SecurityService']['security_policy_id'], $this->SecurityService->id );

				if ( $save1 && $save2 && $save3 ) {
					$this->SecurityService->commit();

					$this->Session->setFlash( __( 'Security Service was successfully added.' ), FLASH_OK );
					$this->redirect( array( 'controller' => 'securityServices', 'action' => 'index' ) );
				} else {
					$this->SecurityService->rollback();
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
				$this->SecurityService->query( 'SET autocommit = 0' );
				$this->SecurityService->begin();

				$save1 = $this->SecurityService->save();
				$delete1 = $this->SecurityService->SecurityServicesServiceContract->deleteAll( array(
					'SecurityServicesServiceContract.security_service_id' => $id
				) );
				$delete2 = $this->SecurityService->SecurityPoliciesSecurityService->deleteAll( array(
					'SecurityPoliciesSecurityService.security_service_id' => $id
				) );
				$save2 = $this->joinServicesContracts( $this->request->data['SecurityService']['service_contract_id'], $this->SecurityService->id );
				$save3 = $this->joinSecurityPolicies( $this->request->data['SecurityService']['security_policy_id'], $this->SecurityService->id );

				if ( $save1 && $delete1 && $delete2 && $save2 ) {
					$this->SecurityService->commit();

					$this->Session->setFlash( __( 'Security Service was successfully edited.' ), FLASH_OK );
					$this->redirect( array( 'controller' => 'securityServices', 'action' => 'index', $id ) );
				}
				else {
					$this->SecurityService->rollback();
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
		if ( ! is_array( $contracts_list ) ) {
			return true;
		}
		
		foreach ( $contracts_list as $id ) {
			$tmp = array(
				'security_service_id' => $service_id,
				'service_contract_id' => $id
			);

			$this->SecurityService->SecurityServicesServiceContract->create();
			if ( ! $this->SecurityService->SecurityServicesServiceContract->save( $tmp ) ) {
				return false;
			}
		}

		return true;
	}

	private function joinSecurityPolicies( $list, $service_id ) {
		if ( ! is_array( $list ) ) {
			return true;
		}
		
		foreach ( $list as $id ) {
			$tmp = array(
				'security_service_id' => $service_id,
				'security_policy_id' => $id
			);

			$this->SecurityService->SecurityPoliciesSecurityService->create();
			if ( ! $this->SecurityService->SecurityPoliciesSecurityService->save( $tmp ) ) {
				return false;
			}
		}

		return true;
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

		$security_policies = $this->SecurityService->SecurityPolicy->find('list', array(
			'conditions' => array(
				'SecurityPolicy.status' => SECURITY_POLICY_RELEASED
			),
			'order' => array('SecurityPolicy.index' => 'ASC'),
			'recursive' => -1
		));

		$this->set( 'types', $types );
		$this->set( 'classifications', $classifications );
		$this->set( 'contracts', $contracts );
		$this->set( 'security_policies', $security_policies );
	}

	private function initAddEditSubtitle() {
		$this->set( 'subtitle_for_layout', __( 'Pretty much the same way a restaurant has a menu, a security program has a menu of services and even sometimes products. It\'s very important to know what security services your program has, since it\'s the core of it\'s delivery and must be well understood and managed.' ) );
	}

}
?>