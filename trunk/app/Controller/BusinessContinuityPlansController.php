<?php
class BusinessContinuityPlansController extends AppController {
	public $helpers = array( 'Html', 'Form' );
	public $components = array( 'Session' );

	public function index() {
		$this->set( 'title_for_layout', __( 'Business Continuity Plans' ) );
		$this->set( 'subtitle_for_layout', __( 'Manage your continuity plans catalogue.' ) );

		$this->paginate = array(
			'conditions' => array(
			),
			'fields' => array(
				'BusinessContinuityPlan.id',
				'BusinessContinuityPlan.title',
				'BusinessContinuityPlan.objective',
				'BusinessContinuityPlan.audit_metric',
				'BusinessContinuityPlan.audit_success_criteria',
				'BusinessContinuityPlan.sponsor',
				'BusinessContinuityPlan.launch_criteria',
				'BusinessContinuityPlan.launch_responsible',
				'BusinessContinuityPlan.opex',
				'BusinessContinuityPlan.capex',
				'BusinessContinuityPlan.resource_utilization'
			),
			'contain' => array(
				'BusinessContinuityTask' => array(
					'fields' => array( 'id', 'step', 'when', 'who', 'does', 'where', 'how' ),
					'order' => 'BusinessContinuityTask.step ASC' 
				),
				'SecurityServiceType' => array(
					'fields' => array( 'id', 'name' )
				)
			),
			'order' => array( 'BusinessContinuityPlan.id' => 'ASC' ),
			'limit' => $this->getPageLimit(),
			'recursive' => 2
		);

		$data = $this->paginate( 'BusinessContinuityPlan' );
		$data = $this->addAuditStatuses( $data );

		$this->set( 'data', $data );
		//debug( $data );
	}

	private function addAuditStatuses( $data ) {
		foreach ( $data as $key => $business_continuity_plan ) {
			$data[ $key ]['BusinessContinuityPlan']['status'] = $this->auditCheck( $business_continuity_plan['BusinessContinuityPlan']['id'] );
		}

		return $data;
	}

	/**
	 * Check audits completion. 
	 * @param  int $id   Security Service ID.
	 * @return array     Result.
	 */
	protected function auditCheck( $id = null ) {
		$data = $this->BusinessContinuityPlan->find( 'first', array(
			'conditions' => array(
				'BusinessContinuityPlan.id' => $id,
			),
			'contain' => array(
				'BusinessContinuityPlanAudit' => array(
					'conditions' => array(
						'BusinessContinuityPlanAudit.result' => null,
						'BusinessContinuityPlanAudit.planned_date <' => date( 'Y-m-d', strtotime('now') )
					)
				)
			), 
			'recursive' => 2
		) );

		$all_done = false;
		if ( empty( $data['BusinessContinuityPlanAudit'] ) ) {
			$all_done = true;
		}

		$data = $this->BusinessContinuityPlan->find( 'first', array(
			'conditions' => array(
				'BusinessContinuityPlan.id' => $id,
			),
			'contain' => array(
				'BusinessContinuityPlanAudit' => array(
					'order' => 'BusinessContinuityPlanAudit.planned_date DESC',
				)
			), 
			'recursive' => 2
		) );

		$last_passed = false;
		if ( isset( $data['BusinessContinuityPlanAudit'][0] ) && $data['BusinessContinuityPlanAudit'][0]['result'] == 1 ) {
			$last_passed = true;
		}
		
		return array(
			'all_done' => $all_done,
			'last_passed' => $last_passed
		);
	}

	public function add() {
		$this->set( 'title_for_layout', __( 'Create a Business Continuity Plan' ) );
		$this->initAddEditSubtitle();
		
		if ( $this->request->is( 'post' ) ) {
			unset( $this->request->data['BusinessContinuityPlan']['id'] );

			$this->BusinessContinuityPlan->set( $this->request->data );

			if ( $this->BusinessContinuityPlan->validates() ) {
				$this->BusinessContinuityPlan->query( 'SET autocommit = 0' );
				$this->BusinessContinuityPlan->begin();

				$save1 = $this->BusinessContinuityPlan->save();
				$save2 = $this->saveAuditDates( $this->request->data['BusinessContinuityPlan']['audit_calendar'], $bcm_id );
				$save3 = $this->saveAudits( $this->request->data['BusinessContinuityPlan']['audit_calendar'], $bcm_id );
				if ( $save1 && $save2 && $save3 ) {
					$this->BusinessContinuityPlan->commit();

					$this->Session->setFlash( __( 'Business Continuity Plan was successfully added.' ), FLASH_OK );
					$this->redirect( array( 'controller' => 'businessContinuityPlans', 'action' => 'index' ) );
				} else {
					$this->BusinessContinuityPlan->rollback();

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
			$id = (int) $this->request->data['BusinessContinuityPlan']['id'];
		}

		$data = $this->BusinessContinuityPlan->find( 'first', array(
			'conditions' => array(
				'BusinessContinuityPlan.id' => $id
			),
			'recursive' => 1
		) );

		if ( empty( $data ) ) {
			throw new NotFoundException();
		}

		$this->set( 'edit', true );
		$this->set( 'title_for_layout', __( 'Edit a Business Continuity Plan' ) );
		$this->initAddEditSubtitle();
		
		if ( $this->request->is( 'post' ) || $this->request->is( 'put' ) ) {

			$this->BusinessContinuityPlan->set( $this->request->data );

			if ( $this->BusinessContinuityPlan->validates() ) {
				$this->BusinessContinuityPlan->query( 'SET autocommit = 0' );
				$this->BusinessContinuityPlan->begin();

				$save1 = $this->BusinessContinuityPlan->save();
				$bcm_id = $this->BusinessContinuityPlan->id;

				$delete1 = $this->BusinessContinuityPlan->BusinessContinuityPlanAuditDate->deleteAll( array(
					'BusinessContinuityPlanAuditDate.business_continuity_plan_id' => $id
				) );

				$save2 = $this->saveAuditDates( $this->request->data['BusinessContinuityPlan']['audit_calendar'], $bcm_id );
				$save3 = $this->saveAudits( $this->request->data['BusinessContinuityPlan']['audit_calendar'], $bcm_id );
				
				if ( $delete1 && $save1 && $save2 && $save3 ) {
					$this->BusinessContinuityPlan->commit();

					$this->Session->setFlash( __( 'Business Continuity Plan was successfully edited.' ), FLASH_OK );
					$this->redirect( array( 'controller' => 'businessContinuityPlans', 'action' => 'index', $id ) );
				}
				else {
					$this->BusinessContinuityPlan->rollback();

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

	private function saveAuditDates( $list, $bcm_id ) {
		foreach ( $list as $date ) {
			$tmp = array(
				'business_continuity_plan_id' => $bcm_id,
				'day' => $date['day'],
				'month' => $date['month']
			);

			$this->BusinessContinuityPlan->BusinessContinuityPlanAuditDate->create();
			if ( ! $this->BusinessContinuityPlan->BusinessContinuityPlanAuditDate->save( $tmp ) ) {
				return false;
			}
		}

		return true;
	}

	private function saveAudits( $list, $bcm_id ) {
		foreach ( $list as $date ) {
			$tmp = array(
				'business_continuity_plan_id' => $bcm_id,
				'planned_date' =>  date('Y') . '-' . $date['month'] . '-' . $date['day'],
				'audit_metric_description' => $this->request->data['BusinessContinuityPlan']['audit_metric'],
				'audit_success_criteria' => $this->request->data['BusinessContinuityPlan']['audit_success_criteria'],
			);

			$exist = $this->BusinessContinuityPlan->BusinessContinuityPlanAudit->find( 'count', array(
				'conditions' => array(
					'BusinessContinuityPlanAudit.planned_date' => date('Y') . '-' . $date['month'] . '-' . $date['day']
				),
				'recursive' => -1
			) );

			if ( ! $exist ) {
				$this->BusinessContinuityPlan->BusinessContinuityPlanAudit->create();
				if ( ! $this->BusinessContinuityPlan->BusinessContinuityPlanAudit->save( $tmp ) ) {
					return false;
				}
			}
		}

		return true;
	}

	private function initOptions() {
		$types = $this->BusinessContinuityPlan->SecurityServiceType->find('list', array(
			'order' => array('SecurityServiceType.name' => 'ASC'),
			'recursive' => -1
		));
		
		$this->set( 'types', $types );
	}

	public function auditCalendarFormEntry() {
		if ( ! $this->request->is( 'ajax' ) ) {
			exit;
		}

		$data = $this->request->data;

		$this->set( 'formKey', (int) $data['formKey'] );
		$this->set( 'model', 'BusinessContinuityPlan' );

		$this->render( '/Elements/ajax/audit_calendar_entry' );
	}

	private function initAddEditSubtitle() {
		$this->set( 'subtitle_for_layout', __( 'Use this form to create or edit a Continuity Plan.' ) );
	}

}