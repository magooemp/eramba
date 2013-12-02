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
				'SecurityService.id',
				'SecurityService.name',
				'SecurityService.objective',
				'SecurityService.documentation_url',
				'SecurityService.audit_metric_description',
				'SecurityService.audit_success_criteria',
				'SecurityService.maintenance_metric_description',
				'SecurityService.opex',
				'SecurityService.capex',
				'SecurityService.resource_utilization'
			),
			'contain' => array(
				'SecurityServiceType' => array(
					'fields' => array( 'id', 'name' )
				),
				'ServiceClassification' => array(
					'fields' => array( 'id', 'name' )
				),
				'User' => array(
					'fields' => array( 'id', 'name', 'surname' )
				),
				'SecurityPolicy' => array(
					'fields' => array( 'id', 'index', 'description', 'status' )
				),
				'Risk' => array(
					'fields' => array( 'id', 'title' )
				),
				'ThirdPartyRisk' => array(
					'fields' => array( 'id', 'title' )
				),
				'SecurityIncident' => array(
					'fields' => array( 'id', 'title' )
				),
				'DataAsset' => array(
					'fields' => array( 'id', 'description' )
				),
				'ComplianceManagement' => array(
					'fields' => array( 'id' ),
					'CompliancePackageItem' => array(
						'fields' => array( 'name' )
					)
				)
			),
			'order' => array('SecurityService.id' => 'ASC'),
			'limit' => $this->getPageLimit(),
			'recursive' => 2
		);

		$data = $this->paginate( 'SecurityService' );
		$data = $this->addAuditStatuses( $data );
		$this->set( 'data', $data );
		
		//debug( $data );
	}

	private function addAuditStatuses( $data ) {
		foreach ( $data as $key => $security_service ) {
			$data[ $key ]['SecurityService']['status'] = $this->auditCheck( $security_service['SecurityService']['id'] );
			$data[ $key ]['SecurityService']['maintenanceStatus'] = $this->maintenanceCheck( $security_service['SecurityService']['id'] );
		}

		return $data;
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

				$service_id = $this->SecurityService->id;

				$save1 = $this->SecurityService->save();
				$save2 = $this->joinServicesContracts( $this->request->data['SecurityService']['service_contract_id'], $service_id );
				$save3 = $this->joinSecurityPolicies( $this->request->data['SecurityService']['security_policy_id'], $service_id );

				$save4 = $this->saveAuditDates( $this->request->data['SecurityService']['audit_calendar'], $service_id );
				$save5 = $this->saveAudits( $this->request->data['SecurityService']['audit_calendar'], $service_id );

				$save6 = $this->saveMaintenanceDates( $this->request->data['SecurityService']['maintenance_calendar'], $service_id );
				$save7 = $this->saveMaintenances( $this->request->data['SecurityService']['maintenance_calendar'], $service_id );

				if ( $save1 && $save2 && $save3 && $save4 && $save5 && $save6 && $save7 ) {
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
		//debug( $data );
		
		$this->set( 'edit', true );
		$this->set( 'title_for_layout', __( 'Edit a Security Service' ) );
		$this->initAddEditSubtitle();
		
		if ( $this->request->is( 'post' ) || $this->request->is( 'put' ) ) {

			//debug($this->request->data);
			//die();

			$this->SecurityService->set( $this->request->data );

			if ( $this->SecurityService->validates() ) {
				$this->SecurityService->query( 'SET autocommit = 0' );
				$this->SecurityService->begin();

				$save1 = $this->SecurityService->save();
				$service_id = $this->SecurityService->id;

				$delete1 = $this->SecurityService->SecurityServicesServiceContract->deleteAll( array(
					'SecurityServicesServiceContract.security_service_id' => $id
				) );
				$delete2 = $this->SecurityService->SecurityPoliciesSecurityService->deleteAll( array(
					'SecurityPoliciesSecurityService.security_service_id' => $id
				) );
				$delete3 = $this->SecurityService->SecurityServiceAuditDate->deleteAll( array(
					'SecurityServiceAuditDate.security_service_id' => $id
				) );
				$delete4 = $this->SecurityService->SecurityServiceMaintenanceDate->deleteAll( array(
					'SecurityServiceMaintenanceDate.security_service_id' => $id
				) );
				$save2 = $this->joinServicesContracts( $this->request->data['SecurityService']['service_contract_id'], $service_id );
				$save3 = $this->joinSecurityPolicies( $this->request->data['SecurityService']['security_policy_id'], $service_id );

				$save4 = $this->saveAuditDates( $this->request->data['SecurityService']['audit_calendar'], $service_id );
				$save5 = $this->saveAudits( $this->request->data['SecurityService']['audit_calendar'], $service_id );

				$save6 = $this->saveMaintenanceDates( $this->request->data['SecurityService']['maintenance_calendar'], $service_id );
				$save7 = $this->saveMaintenances( $this->request->data['SecurityService']['maintenance_calendar'], $service_id );

				if ( $save1 && $delete1 && $delete2 && $delete3 && $delete4 && $save2 && $save3 && $save4 && $save5 && $save6 && $save7 ) {
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

		$this->set( 'data', $data );

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

	private function saveAuditDates( $list, $service_id ) {
		foreach ( $list as $date ) {
			$tmp = array(
				'security_service_id' => $service_id,
				'day' => $date['day'],
				'month' => $date['month']
			);

			$this->SecurityService->SecurityServiceAuditDate->create();
			if ( ! $this->SecurityService->SecurityServiceAuditDate->save( $tmp ) ) {
				return false;
			}
		}

		return true;
	}

	private function saveAudits( $list, $service_id ) {
		foreach ( $list as $date ) {
			$tmp = array(
				'security_service_id' => $service_id,
				'planned_date' =>  date('Y') . '-' . $date['month'] . '-' . $date['day'],
				'audit_metric_description' => $this->request->data['SecurityService']['audit_metric_description'],
				'audit_success_criteria' => $this->request->data['SecurityService']['audit_success_criteria'],
			);

			$exist = $this->SecurityService->SecurityServiceAudit->find( 'count', array(
				'conditions' => array(
					'SecurityServiceAudit.planned_date' => date('Y') . '-' . $date['month'] . '-' . $date['day']
				),
				'recursive' => -1
			) );

			if ( ! $exist ) {
				$this->SecurityService->SecurityServiceAudit->create();
				if ( ! $this->SecurityService->SecurityServiceAudit->save( $tmp ) ) {
					return false;
				}
			}
		}

		return true;
	}

	private function saveMaintenanceDates( $list, $service_id ) {
		foreach ( $list as $date ) {
			$tmp = array(
				'security_service_id' => $service_id,
				'day' => $date['day'],
				'month' => $date['month']
			);

			$this->SecurityService->SecurityServiceMaintenanceDate->create();
			if ( ! $this->SecurityService->SecurityServiceMaintenanceDate->save( $tmp ) ) {
				return false;
			}
		}

		return true;
	}

	private function saveMaintenances( $list, $service_id ) {
		foreach ( $list as $date ) {
			$tmp = array(
				'security_service_id' => $service_id,
				'planned_date' =>  date('Y') . '-' . $date['month'] . '-' . $date['day']
			);

			$exist = $this->SecurityService->SecurityServiceMaintenance->find( 'count', array(
				'conditions' => array(
					'SecurityServiceMaintenance.planned_date' => date('Y') . '-' . $date['month'] . '-' . $date['day']
				),
				'recursive' => -1
			) );

			if ( ! $exist ) {
				$this->SecurityService->SecurityServiceMaintenance->create();
				if ( ! $this->SecurityService->SecurityServiceMaintenance->save( $tmp ) ) {
					return false;
				}
			}
		}

		return true;
	}

	public function auditCalendarFormEntry() {
		if ( ! $this->request->is( 'ajax' ) ) {
			exit;
		}

		$data = $this->request->data;

		$this->set( 'formKey', (int) $data['formKey'] );
		$this->set( 'model', 'SecurityService' );
		if ( ! isset( $data['field'] ) ) {
			$data['field'] = 'audit_calendar';
		}
		$this->set( 'field', $data['field'] );

		$this->render( '/Elements/ajax/audit_calendar_entry' );
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

		$users = $this->getUsersList();
		$security_policies = $this->getSecurityPoliciesList();

		$this->set( 'types', $types );
		$this->set( 'classifications', $classifications );
		$this->set( 'contracts', $contracts );
		$this->set( 'security_policies', $security_policies );
		$this->set( 'users', $users );
	}

	private function initAddEditSubtitle() {
		$this->set( 'subtitle_for_layout', __( 'Pretty much the same way a restaurant has a menu, a security program has a menu of services and even sometimes products. It\'s very important to know what security services your program has, since it\'s the core of it\'s delivery and must be well understood and managed.' ) );
	}

}
?>