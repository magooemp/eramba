<?php
class ComplianceFindingsController extends AppController {
	public $helpers = array( 'Html', 'Form' );
	public $components = array( 'Session' );

	public function index( $compliance_audit_id = null ) {
		$this->set( 'title_for_layout', __( 'List of Expenses' ) );
		$this->set( 'subtitle_for_layout', __( 'This is the list of audit findings for a given audit.' ) );

		$this->paginate = array(
			'conditions' => array(
				'ComplianceFinding.compliance_audit_id' => $compliance_audit_id
			),
			'fields' => array(
				//'Legal.id', 'Legal.name', 'Legal.description', 'Legal.risk_magnifier'
			),
			'order' => array('ComplianceFinding.id' => 'ASC'),
			'limit' => $this->getPageLimit(),
			'recursive' => 0
		);

		$data = $this->paginate( 'ComplianceFinding' );
		$this->set( 'data', $data );
		$this->set( 'compliance_audit_id', $compliance_audit_id );

		//debug( $data );
	}

	public function delete( $id = null ) {
		$data = $this->ComplianceFinding->find( 'count', array(
			'conditions' => array(
				'ComplianceFinding.id' => $id
			)
		) );

		if ( empty( $data ) ) {
			throw new NotFoundException();
		}

		if ( $this->ComplianceFinding->delete( $id ) ) {
			$this->Session->setFlash( __( 'Compliance Finding was successfully deleted.' ), FLASH_OK );
		} else {
			$this->Session->setFlash( __( 'Error while deleting the data. Please try it again.' ), FLASH_ERROR );
		}

		$this->redirect( array( 'controller' => 'complianceAudits', 'action' => 'index' ) );
	}

	public function add( $compliance_audit_id = null, $compliance_package_item_id = null ) {
		$this->set( 'title_for_layout', __( 'Create a Compliance Audit' ) );
		$this->initAddEditSubtitle();
		
		if ( $this->request->is( 'post' ) ) {
			unset( $this->request->data['ComplianceFinding']['id'] );

			$this->ComplianceFinding->set( $this->request->data );

			if ( $this->ComplianceFinding->validates() ) {
				if ( $this->ComplianceFinding->save() ) {
					$this->Session->setFlash( __( 'Compliance Finding was successfully added.' ), FLASH_OK );
					$this->redirect( array( 'controller' => 'complianceAudits', 'action' => 'index' ) );
				} else {
					$this->Session->setFlash( __( 'Error while saving the data. Please try it again.' ), FLASH_ERROR );
				}
			} else {
				$this->Session->setFlash( __( 'One or more inputs you entered are invalid. Please try again.' ), FLASH_ERROR );
			}
		}

		$this->set( 'compliance_audit_id', $compliance_audit_id );
		$this->set( 'compliance_package_item_id', $compliance_package_item_id );
		$this->set( 'compliance_package_item_name', $this->getCompliancePackageItemName( $compliance_package_item_id ) );

		$this->initOptions();
	}

	public function edit( $id = null ) {
		$id = (int) $id;

		if ( ! empty( $this->request->data ) ) {
			$id = (int) $this->request->data['ComplianceFinding']['id'];
		}

		$data = $this->ComplianceFinding->find( 'first', array(
			'conditions' => array(
				'ComplianceFinding.id' => $id
			),
			'recursive' => -1
		) );

		if ( empty( $data ) ) {
			throw new NotFoundException();
		}

		$this->set( 'edit', true );
		$this->set( 'title_for_layout', __( 'Edit a Compliance Audit' ) );
		$this->initAddEditSubtitle();
		
		if ( $this->request->is( 'post' ) || $this->request->is( 'put' ) ) {

			$this->ComplianceFinding->set( $this->request->data );

			if ( $this->ComplianceFinding->validates() ) {
				if ( $this->ComplianceFinding->save() ) {
					$this->Session->setFlash( __( 'Compliance Finding was successfully edited.' ), FLASH_OK );
					$this->redirect( array( 'controller' => 'complianceAudits', 'action' => 'index' ) );
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

		$compliance_audit_id = $data['ComplianceFinding']['compliance_audit_id'];
		$compliance_package_item_id = $data['ComplianceFinding']['compliance_package_item_id'];
		$this->set( 'compliance_audit_id', $compliance_audit_id );
		$this->set( 'compliance_package_item_id', $compliance_package_item_id );
		$this->set( 'compliance_package_item_name', $this->getCompliancePackageItemName( $compliance_package_item_id ) );

		$this->initOptions();

		$this->render( 'add' );
	}

	private function getCompliancePackageItemName( $id = null ) {
		if ( $id == null ) {
			return false;
		}
		$id = (int) $id;

		$this->loadModel('CompliancePackageItem');
		$data = $this->CompliancePackageItem->find('first', array(
			'conditions' => array(
				'CompliancePackageItem.id' => $id
			),
			'fields' => array( 'CompliancePackageItem.name' )
		) );

		return $data['CompliancePackageItem']['name'];
	}

	private function initOptions() {
		$statuses = $this->ComplianceFinding->ComplianceFindingStatus->find('list', array(
			'order' => array('ComplianceFindingStatus.name' => 'ASC'),
			'recursive' => -1
		));

		$this->set( 'statuses', $statuses );
	}

	private function initAddEditSubtitle() {
		$this->set( 'subtitle_for_layout', __( 'Use this form to create or edit an audit finding' ) );
	}

}
?>