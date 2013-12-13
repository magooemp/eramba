<?php
class ComplianceManagementsController extends AppController {
	public $helpers = array( 'Html', 'Form' );
	public $components = array( 'Session' );

	public function index() {
		$this->set( 'title_for_layout', __( 'Compliance Management' ) );
		$this->set( 'subtitle_for_layout', __( 'Select the third party who wish to work with.' ) );

		$this->loadModel( 'ThirdParty' );
		$this->paginate = array(
			'conditions' => array(
			),
			'fields' => array(
				'ThirdParty.id',
				'ThirdParty.name',
				'ThirdParty.description'
			),
			'order' => array( 'ThirdParty.id' => 'ASC' ),
			'limit' => $this->getPageLimit(),
			'recursive' => 0
		);

		$data = $this->paginate( 'ThirdParty' );
		$this->set( 'data', $data );
	}

	public function analyze( $tp_id = null ) {
		$this->loadModel( 'ThirdParty' );

		$data = $this->ThirdParty->find( 'first', array(
			'conditions' => array(
				'ThirdParty.id' => $tp_id
			),
			'fields' => array( 'ThirdParty.id', 'ThirdParty.name' ),
			'contain' => array(
				'CompliancePackage' => array(
					'CompliancePackageItem' => array(
						'ComplianceManagement' => array()
					)
				)
			),
			'recursive' => 2
		) );

		if ( empty( $data ) ) {
			throw new NotFoundException();
		}

		$this->set( 'title_for_layout', __( 'Compliance Management:' ) . ' ' . $data['ThirdParty']['name'] );
		$this->set( 'data', $data );
	}

	public function add( $compliance_package_item_id = null ) {
		$this->set( 'title_for_layout', __( 'Create a Compliance Package' ) );
		$this->initAddEditSubtitle();
		
		if ( $this->request->is( 'post' ) ) {
			unset( $this->request->data['ComplianceManagement']['id'] );

			$this->ComplianceManagement->set( $this->request->data );

			if ( $this->ComplianceManagement->validates() ) {
				$this->ComplianceManagement->query( 'SET autocommit = 0' );
				$this->ComplianceManagement->begin();

				$save1 = $this->ComplianceManagement->save();
				$save2 = $this->joinSecurityServices( $this->request->data['ComplianceManagement']['security_service_id'], $this->ComplianceManagement->id );
				$save3 = $this->joinSecurityPolicies( $this->request->data['ComplianceManagement']['security_policy_id'], $this->ComplianceManagement->id );

				if ( $save1 && $save2 && $save3 ) {
					$this->ComplianceManagement->commit();

					$this->Session->setFlash( __( 'Compliance Management was successfully added.' ), FLASH_OK );
					$this->redirect( array( 'controller' => 'complianceManagements', 'action' => 'index' ) );
				} else {
					$this->ComplianceManagement->rollback();
					$this->Session->setFlash( __( 'Error while saving the data. Please try it again.' ), FLASH_ERROR );
				}
			} else {
				$this->Session->setFlash( __( 'One or more inputs you entered are invalid. Please try again.' ), FLASH_ERROR );
			}
		}

		$this->set( 'compliance_package_item_id', $compliance_package_item_id );

		$this->initOptions();
	}

	public function edit( $id = null ) {
		$id = (int) $id;

		if ( ! empty( $this->request->data ) ) {
			$id = (int) $this->request->data['ComplianceManagement']['id'];
		}

		$data = $this->ComplianceManagement->find( 'first', array(
			'conditions' => array(
				'ComplianceManagement.id' => $id
			),
			'recursive' => 1
		) );

		if ( empty( $data ) ) {
			throw new NotFoundException();
		}

		$this->set( 'compliance_package_item_id', $data['ComplianceManagement']['compliance_package_item_id'] );

		$this->set( 'edit', true );
		$this->set( 'title_for_layout', __( 'Edit a Compliance Package' ) );
		$this->initAddEditSubtitle();
		
		if ( $this->request->is( 'post' ) || $this->request->is( 'put' ) ) {
			//debug($this->request->data );
			//die();

			$this->ComplianceManagement->set( $this->request->data );

			if ( $this->ComplianceManagement->validates() ) {
				$this->ComplianceManagement->query( 'SET autocommit = 0' );
				$this->ComplianceManagement->begin();

				$delete = $this->deleteJoins( $id );
				$save1 = $this->ComplianceManagement->save();
				$save2 = $this->joinSecurityServices( $this->request->data['ComplianceManagement']['security_service_id'], $this->ComplianceManagement->id );
				$save3 = $this->joinSecurityPolicies( $this->request->data['ComplianceManagement']['security_policy_id'], $this->ComplianceManagement->id );

				if ( $delete && $save1 && $save2 && $save3 ) {
					$this->ComplianceManagement->commit();

					$this->Session->setFlash( __( 'Compliance Management was successfully edited.' ), FLASH_OK );
					$this->redirect( array( 'controller' => 'complianceManagements', 'action' => 'index' ) );
				}
				else {
					$this->ComplianceManagement->rollback();
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

	private function joinSecurityServices( $list, $compliance_management_id ) {
		if ( ! is_array( $list ) ) {
			return true;
		}

		foreach ( $list as $id ) {
			$tmp = array(
				'compliance_management_id' => $compliance_management_id,
				'security_service_id' => $id
			);

			$this->ComplianceManagement->ComplianceManagementsSecurityService->create();
			if ( ! $this->ComplianceManagement->ComplianceManagementsSecurityService->save( $tmp ) ) {
				return false;
			}
		}

		return true;
	}

	private function joinSecurityPolicies( $list, $compliance_management_id ) {
		if ( ! is_array( $list ) ) {
			return true;
		}

		foreach ( $list as $id ) {
			$tmp = array(
				'compliance_management_id' => $compliance_management_id,
				'security_policy_id' => $id
			);

			$this->ComplianceManagement->ComplianceManagementsSecurityPolicy->create();
			if ( ! $this->ComplianceManagement->ComplianceManagementsSecurityPolicy->save( $tmp ) ) {
				return false;
			}
		}

		return true;
	}

	/**
	 * Delete all many to many joins in related tables.
	 * @param  integer $id Compliance Management ID
	 */
	private function deleteJoins( $id ) {
		$delete1 = $this->ComplianceManagement->ComplianceManagementsSecurityService->deleteAll( array(
			'ComplianceManagementsSecurityService.compliance_management_id' => $id
		) );

		$delete2 = $this->ComplianceManagement->ComplianceManagementsSecurityPolicy->deleteAll( array(
			'ComplianceManagementsSecurityPolicy.compliance_management_id' => $id
		) );

		if ( $delete1 && $delete2 ) {
			return true;
		}

		return false;
	}

	/**
	 * Initialize options for join elements.
	 */
	private function initOptions() {
		$strategies = $this->ComplianceManagement->ComplianceTreatmentStrategy->find('list', array(
			'order' => array('ComplianceTreatmentStrategy.name' => 'ASC'),
			'recursive' => -1
		));

		$exceptions = $this->ComplianceManagement->ComplianceException->find('list', array(
			'order' => array('ComplianceException.title' => 'ASC'),
			'recursive' => -1
		));

		$security_services = $this->ComplianceManagement->SecurityService->find('list', array(
			'conditions' => array(
				'SecurityService.security_service_type_id' => SECURITY_SERVICE_PRODUCTION
			),
			'order' => array('SecurityService.name' => 'ASC'),
			'recursive' => -1
		));

		$security_policies = $this->getSecurityPoliciesList();

		$this->set( 'strategies', $strategies );
		$this->set( 'exceptions', $exceptions );
		$this->set( 'security_services', $security_services );
		$this->set( 'security_policies', $security_policies );
	}

	private function initAddEditSubtitle() {
		$this->set( 'subtitle_for_layout', __( 'Select which mitigation strategy (response) you\'ll provide to this compliance package item and what\'s the regulator feedback on this particular item (status)' ) );
	}

}
?>