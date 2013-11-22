<?php
class ComplianceAuditsController extends AppController {
	public $helpers = array( 'Html', 'Form' );
	public $components = array( 'Session' );

	public function index() {
		$this->set( 'title_for_layout', __( 'Audit Calendar' ) );
		$this->set( 'subtitle_for_layout', __( 'Keeping tidy a calendar of Audits is helpful for prepation and planning. In this section you can keep track all audit findings (non-compliances) in order to work on their mitigation plans.' ) );

		$this->loadModel( 'ThirdParty' );
		$this->paginate = array(
			'conditions' => array(
			),
			'contain' => array(
				'ComplianceAudit' => array(
					'ComplianceFinding' => array()
				)
			),
			'fields' => array(
			),
			'order' => array('ThirdParty.id' => 'ASC'),
			'limit' => $this->getPageLimit(),
			'recursive' => 2
		);

		$data = $this->paginate( 'ThirdParty' );
		$this->set( 'data', $data );

		//debug( $data );
	}

	public function delete( $id = null ) {
		$data = $this->ComplianceAudit->find( 'count', array(
			'conditions' => array(
				'ComplianceAudit.id' => $id
			)
		) );

		if ( empty( $data ) ) {
			throw new NotFoundException();
		}

		if ( $this->ComplianceAudit->delete( $id ) ) {
			$this->Session->setFlash( __( 'Compliance Audit was successfully deleted.' ), FLASH_OK );
		} else {
			$this->Session->setFlash( __( 'Error while deleting the data. Please try it again.' ), FLASH_ERROR );
		}

		$this->redirect( array( 'controller' => 'complianceAudits', 'action' => 'index' ) );
	}

	public function add() {
		$this->set( 'title_for_layout', __( 'Create a Compliance Audit' ) );
		$this->initAddEditSubtitle();
		
		if ( $this->request->is( 'post' ) ) {
			unset( $this->request->data['ComplianceAudit']['id'] );

			$this->ComplianceAudit->set( $this->request->data );

			if ( $this->ComplianceAudit->validates() ) {
				if ( $this->ComplianceAudit->save() ) {
					$this->Session->setFlash( __( 'Compliance Audit was successfully added.' ), FLASH_OK );
					$this->redirect( array( 'controller' => 'complianceAudits', 'action' => 'index' ) );
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
			$id = (int) $this->request->data['ComplianceAudit']['id'];
		}

		$data = $this->ComplianceAudit->find( 'first', array(
			'conditions' => array(
				'ComplianceAudit.id' => $id
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

			$this->ComplianceAudit->set( $this->request->data );

			if ( $this->ComplianceAudit->validates() ) {
				if ( $this->ComplianceAudit->save() ) {
					$this->Session->setFlash( __( 'Compliance Audit was successfully edited.' ), FLASH_OK );
					$this->redirect( array( 'controller' => 'complianceAudits', 'action' => 'index', $id ) );
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

	private function initOptions() {
		$third_parties = $this->ComplianceAudit->ThirdParty->find('all', array(
			'order' => array('ThirdParty.name' => 'ASC'),
			'contain' => array(
				'CompliancePackage' => array(
					'fields' => array( 'id' )
				)
			),
			'recursive' => 2
		));

		$compliance_packages = array();
		foreach ( $third_parties as $third_party ) {
			if ( ! empty( $third_party['CompliancePackage'] ) ) {
				$compliance_packages[ $third_party['ThirdParty']['id'] ] = $third_party['ThirdParty']['name'];
			}
		}
		
		$this->set( 'compliance_packages', $compliance_packages );
	}

	private function initAddEditSubtitle() {
		$this->set( 'subtitle_for_layout', __( 'Record your next audits.' ) );
	}

}
?>