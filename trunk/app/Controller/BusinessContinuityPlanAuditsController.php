<?php
class BusinessContinuityPlanAuditsController extends AppController {
	public $helpers = array( 'Html', 'Form' );
	public $components = array( 'Session' );

	public function index( $id = null ) {
		$this->set( 'title_for_layout', __( 'Business Continuity Plans Audit Report' ) );
		$this->set( 'subtitle_for_layout', __( 'This is a report of all the audits registed for this service.' ) );

		$this->paginate = array(
			'conditions' => array(
				'BusinessContinuityPlanAudit.business_continuity_plan_id' => $id
			),
			'fields' => array(
			),
			'order' => array('BusinessContinuityPlanAudit.id' => 'ASC'),
			'limit' => $this->getPageLimit(),
			'recursive' => 0
		);

		$data = $this->paginate( 'BusinessContinuityPlanAudit' );
		$this->set( 'data', $data );
		//debug( $data );
	}

	public function delete( $id = null ) {
		$data = $this->BusinessContinuityPlanAudit->find( 'count', array(
			'conditions' => array(
				'BusinessContinuityPlanAudit.id' => $id
			)
		) );

		if ( empty( $data ) ) {
			throw new NotFoundException();
		}

		if ( $this->BusinessContinuityPlanAudit->delete( $id ) ) {
			$this->Session->setFlash( __( 'Business Continuity Plan Audit was successfully deleted.' ), FLASH_OK );
		} else {
			$this->Session->setFlash( __( 'Error while deleting the data. Please try it again.' ), FLASH_ERROR );
		}

		$this->redirect( array( 'controller' => 'businessContinuityPlans', 'action' => 'index' ) );
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
			$id = (int) $this->request->data['BusinessContinuityPlanAudit']['id'];
		}

		$data = $this->BusinessContinuityPlanAudit->find( 'first', array(
			'conditions' => array(
				'BusinessContinuityPlanAudit.id' => $id
			),
			'recursive' => -1
		) );

		if ( empty( $data ) ) {
			throw new NotFoundException();
		}

		$this->set( 'edit', true );
		$this->set( 'title_for_layout', __( 'Edit a Business Continuity Plan Audit' ) );
		$this->initAddEditSubtitle();
		
		if ( $this->request->is( 'post' ) || $this->request->is( 'put' ) ) {

			$this->BusinessContinuityPlanAudit->set( $this->request->data );

			if ( $this->BusinessContinuityPlanAudit->validates() ) {
				if ( $this->BusinessContinuityPlanAudit->save() ) {
					$this->Session->setFlash( __( 'Business Continuity Plan Audit was successfully edited.' ), FLASH_OK );
					$bcm_id = $data['BusinessContinuityPlanAudit']['business_continuity_plan_id'];
					$this->redirect( array( 'controller' => 'businessContinuityPlanAudits', 'action' => 'index', $bcm_id ) );
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
		$this->set( 'subtitle_for_layout', __( 'The objective is to audit the security control for efficiency utilizing the metrics reviews and success criteria defined on the continuity plan. You should be able to add evidence that suppors the audit.' ) );
	}

}
?>