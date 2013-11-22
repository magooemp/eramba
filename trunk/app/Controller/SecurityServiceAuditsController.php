<?php
class SecurityServiceAuditsController extends AppController {
	public $helpers = array( 'Html', 'Form' );
	public $components = array( 'Session' );

	public function index( $id = null ) {
		$this->set( 'title_for_layout', __( 'Security Services Audit Report' ) );
		$this->set( 'subtitle_for_layout', __( 'This is a report of all the audits registed for this service.' ) );

		$this->paginate = array(
			'conditions' => array(
				'SecurityServiceAudit.security_service_id' => $id
			),
			'fields' => array(
			),
			'order' => array('SecurityServiceAudit.id' => 'ASC'),
			'limit' => $this->getPageLimit(),
			'recursive' => 0
		);

		$data = $this->paginate( 'SecurityServiceAudit' );
		$this->set( 'data', $data );
		debug( $data );
	}

	public function delete( $id = null ) {
		$data = $this->SecurityServiceAudit->find( 'count', array(
			'conditions' => array(
				'SecurityServiceAudit.id' => $id
			)
		) );

		if ( empty( $data ) ) {
			throw new NotFoundException();
		}

		if ( $this->SecurityServiceAudit->delete( $id ) ) {
			$this->Session->setFlash( __( 'Security Service Audit was successfully deleted.' ), FLASH_OK );
		} else {
			$this->Session->setFlash( __( 'Error while deleting the data. Please try it again.' ), FLASH_ERROR );
		}

		$this->redirect( array( 'controller' => 'securityServices', 'action' => 'index' ) );
	}

	/*public function add() {
		$this->set( 'title_for_layout', __( 'Create a Legal Constrain' ) );
		$this->initAddEditSubtitle();
		
		if ( $this->request->is( 'post' ) ) {
			unset( $this->request->data['Legal']['id'] );

			$this->Legal->set( $this->request->data );

			if ( $this->Legal->validates() ) {
				if ( $this->Legal->save() ) {
					$this->Session->setFlash( __( 'Legal Constrain was successfully added.' ), FLASH_OK );
					$this->redirect( array( 'controller' => 'legals', 'action' => 'index' ) );
				} else {
					$this->Session->setFlash( __( 'Error while saving the data. Please try it again.' ), FLASH_ERROR );
				}
			} else {
				$this->Session->setFlash( __( 'One or more inputs you entered are invalid. Please try again.' ), FLASH_ERROR );
			}
		}
	}
*/
	public function edit( $id = null ) {
		$id = (int) $id;

		if ( ! empty( $this->request->data ) ) {
			$id = (int) $this->request->data['SecurityServiceAudit']['id'];
		}

		$data = $this->SecurityServiceAudit->find( 'first', array(
			'conditions' => array(
				'SecurityServiceAudit.id' => $id
			),
			'recursive' => -1
		) );

		if ( empty( $data ) ) {
			throw new NotFoundException();
		}

		$this->set( 'edit', true );
		$this->set( 'title_for_layout', __( 'Edit a Security Service Audit' ) );
		$this->initAddEditSubtitle();
		
		if ( $this->request->is( 'post' ) || $this->request->is( 'put' ) ) {

			$this->SecurityServiceAudit->set( $this->request->data );

			if ( $this->SecurityServiceAudit->validates() ) {
				if ( $this->SecurityServiceAudit->save() ) {
					$this->Session->setFlash( __( 'Security Service Audit was successfully edited.' ), FLASH_OK );
					$this->redirect( array( 'controller' => 'securityServiceAudits', 'action' => 'index', $id ) );
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
		$users = $this->getUsersList();

		$this->set( 'users', $users );
	}


	private function initAddEditSubtitle() {
		$this->set( 'subtitle_for_layout', __( 'The objective is to audit the security control for efficiency utilizing the metrics reviews and success criteria defined on the control. You should be able to add evidence that suppors the audit.' ) );
	}

}
?>