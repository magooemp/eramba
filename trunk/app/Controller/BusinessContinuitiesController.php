<?php
class BusinessContinuitiesController extends AppController {
	public $helpers = array( 'Html', 'Form' );
	public $components = array( 'Session' );

	public function index() {
		$this->set( 'title_for_layout', __( 'Business Based - Risk Analysis' ) );
		$this->set( 'subtitle_for_layout', __( 'Identifying and analysing Business Risks can be usefull if executed in a simple and practical way. For each Business line, identify and analyse risks. You will later have the option to mitigate them by the use of controls or Continuity Plans.' ) );

		$this->paginate = array(
			'conditions' => array(
			),
			'fields' => array(
				//'Legal.id', 'Legal.name', 'Legal.description', 'Legal.risk_magnifier'
			),
			'order' => array('BusinessContinuity.id' => 'ASC'),
			'limit' => $this->getPageLimit(),
			'recursive' => 0
		);

		$data = $this->paginate( 'BusinessContinuity' );
		$this->set( 'data', $data );
	}

	public function delete( $id = null ) {
		$data = $this->BusinessContinuity->find( 'count', array(
			'conditions' => array(
				'BusinessContinuity.id' => $id
			)
		) );

		if ( empty( $data ) ) {
			throw new NotFoundException();
		}

		$this->BusinessContinuity->delete( $id );
		$this->deleteJoins( $id );

		$this->Session->setFlash( __( 'Business Continuity was successfully deleted.' ), FLASH_OK );
		$this->redirect( array( 'controller' => 'businessContinuities', 'action' => 'index' ) );
	}

	public function add() {
		$this->set( 'title_for_layout', __( 'Create a Business Continuity' ) );
		$this->initAddEditSubtitle();
		
		if ( $this->request->is( 'post' ) ) {
			unset( $this->request->data['BusinessContinuity']['id'] );

			$this->request->data['BusinessContinuity']['risk_classification_id'] = $this->fixClassificationIds();

			$risk_score = $this->calculateRiskScore();
			$this->request->data['BusinessContinuity']['risk_score'] = $risk_score;

			$this->BusinessContinuity->set( $this->request->data );

			if ( $this->BusinessContinuity->validates() ) {
				$this->BusinessContinuity->query( 'SET autocommit = 0' );
				$this->BusinessContinuity->begin();

				$save1 = $this->BusinessContinuity->save();
				$save2 = $this->joinBusinessUnits( $this->request->data['BusinessContinuity']['business_unit_id'], $this->BusinessContinuity->id );
				$save3 = $this->joinRisksThreats( $this->request->data['BusinessContinuity']['threat_id'], $this->BusinessContinuity->id );
				$save4 = $this->joinRisksVulnerabilities( $this->request->data['BusinessContinuity']['vulnerability_id'], $this->BusinessContinuity->id );
				if ( isset( $this->request->data['BusinessContinuity']['security_service_id'] ) ) {
					$save5 = $this->joinRisksSecurityServices( $this->request->data['BusinessContinuity']['security_service_id'], $this->BusinessContinuity->id );
				} else {
					$save5 = true;
				}
				if ( isset( $this->request->data['BusinessContinuity']['risk_exception_id'] ) ) {
					$save6 = $this->joinRisksRiskExceptions( $this->request->data['BusinessContinuity']['risk_exception_id'], $this->BusinessContinuity->id );
				} else {
					$save6 = true;
				}
				$save7 = $this->joinRiskClassifications( $this->request->data['BusinessContinuity']['risk_classification_id'], $this->BusinessContinuity->id );

				if ( $save1 && $save2 && $save3 && $save4 && $save5 && $save6 && $save7 ) {
					$this->BusinessContinuity->commit();				
	
					$this->Session->setFlash( __( 'Business Continuity was successfully added.' ), FLASH_OK );
					$this->redirect( array( 'controller' => 'businessContinuities', 'action' => 'index' ) );
				} else {
					$this->BusinessContinuity->rollback();

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
			$id = (int) $this->request->data['BusinessContinuity']['id'];
		}

		$data = $this->BusinessContinuity->find( 'first', array(
			'conditions' => array(
				'BusinessContinuity.id' => $id
			),
			'recursive' => 1
		) );

		if ( empty( $data ) ) {
			throw new NotFoundException();
		}

		$this->set( 'edit', true );
		$this->set( 'title_for_layout', __( 'Edit a Business Continuity' ) );
		$this->initAddEditSubtitle();
		
		if ( $this->request->is( 'post' ) || $this->request->is( 'put' ) ) {

			$this->request->data['BusinessContinuity']['risk_classification_id'] = $this->fixClassificationIds();

			$risk_score = $this->calculateRiskScore();
			$this->request->data['BusinessContinuity']['risk_score'] = $risk_score;

			$this->BusinessContinuity->set( $this->request->data );

			if ( $this->BusinessContinuity->validates() ) {
				$this->BusinessContinuity->query( 'SET autocommit = 0' );
				$this->BusinessContinuity->begin();

				$delete = $this->deleteJoins( $id );
				$save1 = $this->BusinessContinuity->save();
				$save2 = $this->joinBusinessUnits( $this->request->data['BusinessContinuity']['business_unit_id'], $this->BusinessContinuity->id );
				$save3 = $this->joinRisksThreats( $this->request->data['BusinessContinuity']['threat_id'], $this->BusinessContinuity->id );
				$save4 = $this->joinRisksVulnerabilities( $this->request->data['BusinessContinuity']['vulnerability_id'], $this->BusinessContinuity->id );
				if ( isset( $this->request->data['BusinessContinuity']['security_service_id'] ) ) {
					$save5 = $this->joinRisksSecurityServices( $this->request->data['BusinessContinuity']['security_service_id'], $this->BusinessContinuity->id );
				} else {
					$save5 = true;
				}
				if ( isset( $this->request->data['BusinessContinuity']['risk_exception_id'] ) ) {
					$save6 = $this->joinRisksRiskExceptions( $this->request->data['BusinessContinuity']['risk_exception_id'], $this->BusinessContinuity->id );
				} else {
					$save6 = true;
				}
				$save7 = $this->joinRiskClassifications( $this->request->data['BusinessContinuity']['risk_classification_id'], $this->BusinessContinuity->id );

				if ( $delete && $save1 && $save2 && $save3 && $save4 && $save5 && $save6 && $save7 ) {
					$this->BusinessContinuity->commit();

					$this->Session->setFlash( __( 'Business Continuity was successfully edited.' ), FLASH_OK );
					$this->redirect( array( 'controller' => 'businessContinuities', 'action' => 'index', $id ) );
				}
				else {
					$this->BusinessContinuity->rollback();
					
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

	private function fixClassificationIds() {
		$tmp = array();
		foreach ( $this->request->data['BusinessContinuity']['risk_classification_id'] as $classification_id ) {
			if ( $classification_id ) {
				$tmp[] = $classification_id;
			}
		}

		return $tmp;
	}

	/**
	 * Calculate Risk Score for this Risk from given classification values.
	 * @return int Risk Score.
	 */
	private function calculateRiskScore() {
		$classification_ids = $this->request->data['BusinessContinuity']['risk_classification_id'];
		if ( empty( $classification_ids ) ) {
			return 0;
		}

		$classifications = $this->BusinessContinuity->RiskClassification->find('all', array(
			'conditions' => array(
				'RiskClassification.id' => $classification_ids
			),
			'fields' => array( 'id', 'value' ),
			'recursive' => -1
		));


		$classification_sum = 0;
		foreach ( $classifications as $classification ) {
			$classification_sum += $classification['RiskClassification']['value'];
		}


		return $classification_sum;
	}

	/**
	 * Join Assets and Risks.
	 * @param  array   $list    Asset IDs list.
	 * @param  integer $business_continuity_id Risk ID.
	 */
	private function joinBusinessUnits( $list, $business_continuity_id ) {
		foreach ( $list as $id ) {
			$tmp = array(
				'business_continuity_id' => $business_continuity_id,
				'business_unit_id' => $id
			);

			$this->BusinessContinuity->BusinessContinuitiesBusinessUnit->create();
			if ( ! $this->BusinessContinuity->BusinessContinuitiesBusinessUnit->save( $tmp ) ) {
				return false;
			}
		}

		return true;
	}

	/**
	 * Join Risks and Threats.
	 * @param  array   $list    Threat IDs list.
	 * @param  integer $business_continuity_id Risk ID.
	 */
	private function joinRisksThreats( $list, $business_continuity_id ) {
		foreach ( $list as $id ) {
			$tmp = array(
				'business_continuity_id' => $business_continuity_id,
				'threat_id' => $id
			);

			$this->BusinessContinuity->BusinessContinuitiesThreat->create();
			if ( ! $this->BusinessContinuity->BusinessContinuitiesThreat->save( $tmp ) ) {
				return false;
			}
		}

		return true;
	}

	/**
	 * Join Risks and Vulnerabilities.
	 * @param  array   $list    Vulnerability IDs list.
	 * @param  integer $business_continuity_id Risk ID.
	 */
	private function joinRisksVulnerabilities( $list, $business_continuity_id ) {
		foreach ( $list as $id ) {
			$tmp = array(
				'business_continuity_id' => $business_continuity_id,
				'vulnerability_id' => $id
			);

			$this->BusinessContinuity->BusinessContinuitiesVulnerability->create();
			if ( ! $this->BusinessContinuity->BusinessContinuitiesVulnerability->save( $tmp ) ) {
				return false;
			}
		}

		return true;
	}

	/**
	 * Join Risks and Security Services.
	 * @param  array   $list    Security Service IDs list.
	 * @param  integer $business_continuity_id Risk ID.
	 */
	private function joinRisksSecurityServices( $list, $business_continuity_id ) {
		foreach ( $list as $id ) {
			$tmp = array(
				'business_continuity_id' => $business_continuity_id,
				'security_service_id' => $id
			);

			$this->BusinessContinuity->BusinessContinuitiesSecurityService->create();
			if ( ! $this->BusinessContinuity->BusinessContinuitiesSecurityService->save( $tmp ) ) {
				return false;
			}
		}

		return true;
	}

	/**
	 * Join Risks and Risk Exceptions.
	 * @param  array   $list    Risk Exception IDs list.
	 * @param  integer $business_continuity_id Risk ID.
	 */
	private function joinRisksRiskExceptions( $list, $business_continuity_id ) {
		foreach ( $list as $id ) {
			$tmp = array(
				'business_continuity_id' => $business_continuity_id,
				'risk_exception_id' => $id
			);

			$this->BusinessContinuity->BusinessContinuitiesRiskException->create();
			if ( ! $this->BusinessContinuity->BusinessContinuitiesRiskException->save( $tmp ) ) {
				return false;
			}
		}

		return true;
	}

	private function joinRiskClassifications( $list, $business_continuity_id ) {
		if ( ! is_array( $list ) || empty( $list ) ) {
			return true;
		}
		
		foreach ( $list as $risk_classification_id ) {
			if ( ! $risk_classification_id )
				continue;

			$tmp = array(
				'business_continuity_id' => $business_continuity_id,
				'risk_classification_id' => $risk_classification_id
			);

			$this->BusinessContinuity->BusinessContinuitiesRiskClassification->create();
			if ( ! $this->BusinessContinuity->BusinessContinuitiesRiskClassification->save( $tmp ) ) {
				return false;
			}
		}
		return true;
	}

	/**
	 * Delete all many to many joins in related tables.
	 * @param  integer $id Risk ID
	 */
	private function deleteJoins( $id ) {
		$delete1 = $this->BusinessContinuity->BusinessContinuitiesBusinessUnit->deleteAll( array(
			'BusinessContinuitiesBusinessUnit.business_continuity_id' => $id
		) );

		$delete2 = $this->BusinessContinuity->BusinessContinuitiesThreat->deleteAll( array(
			'BusinessContinuitiesThreat.business_continuity_id' => $id
		) );

		$delete3 = $this->BusinessContinuity->BusinessContinuitiesVulnerability->deleteAll( array(
			'BusinessContinuitiesVulnerability.business_continuity_id' => $id
		) );

		$delete4 = $this->BusinessContinuity->BusinessContinuitiesSecurityService->deleteAll( array(
			'BusinessContinuitiesSecurityService.business_continuity_id' => $id
		) );

		$delete5 = $this->BusinessContinuity->BusinessContinuitiesRiskException->deleteAll( array(
			'BusinessContinuitiesRiskException.business_continuity_id' => $id
		) );

		$delete6 = $this->BusinessContinuity->BusinessContinuitiesRiskClassification->deleteAll( array(
			'BusinessContinuitiesRiskClassification.business_continuity_id' => $id
		) );

		if ( $delete1 && $delete2 && $delete3 && $delete4 && $delete5 && $delete6 ) {
			return true;
		}

		return false;
	}

	/**
	 * Initialize options for join elements.
	 */
	private function initOptions() {
		$this->loadModel( 'RiskClassificationType' );
		$classifications = $this->RiskClassificationType->find('all', array(
			'order' => array('RiskClassificationType.name' => 'ASC'),
			'recursive' => 1
		));

		$strategies = $this->BusinessContinuity->RiskMitigationStrategy->find('list', array(
			'order' => array('RiskMitigationStrategy.name' => 'ASC'),
			'recursive' => -1
		));

		$business_units = $this->BusinessContinuity->BusinessUnit->find('list', array(
			'order' => array('BusinessUnit.name' => 'ASC'),
			'recursive' => -1
		));

		$threats = $this->BusinessContinuity->Threat->find('list', array(
			'order' => array('Threat.name' => 'ASC'),
			'recursive' => -1
		));

		$vulnerabilities = $this->BusinessContinuity->Vulnerability->find('list', array(
			'order' => array('Vulnerability.name' => 'ASC'),
			'recursive' => -1
		));

		$services = $this->BusinessContinuity->SecurityService->find('list', array(
			'order' => array('SecurityService.name' => 'ASC'),
			'recursive' => -1
		));

		$risk_exceptions = $this->BusinessContinuity->RiskException->find('list', array(
			'order' => array('RiskException.title' => 'ASC'),
			'recursive' => -1
		));

		$mitigate_id = $this->BusinessContinuity->RiskMitigationStrategy->find( 'first', array(
			'conditions' => array(
				'RiskMitigationStrategy.type' => RISK_MITIGATION_MITIGATE
			),
			'recursive' => -1
		) );
		
		$accept_id = $this->BusinessContinuity->RiskMitigationStrategy->find( 'first', array(
			'conditions' => array(
				'RiskMitigationStrategy.type' => RISK_MITIGATION_ACCEPT
			),
			'recursive' => -1
		) );

		$transfer_id = $this->BusinessContinuity->RiskMitigationStrategy->find( 'first', array(
			'conditions' => array(
				'RiskMitigationStrategy.type' => RISK_MITIGATION_TRANSFER
			),
			'recursive' => -1
		) );

		$users = $this->getUsersList();

		$this->set( 'classifications', $classifications );
		$this->set( 'strategies', $strategies );
		$this->set( 'business_units', $business_units );
		$this->set( 'threats', $threats );
		$this->set( 'vulnerabilities', $vulnerabilities );
		$this->set( 'services', $services );
		$this->set( 'risk_exceptions', $risk_exceptions );
		$this->set( 'mitigate_id', $mitigate_id['RiskMitigationStrategy']['id'] );
		$this->set( 'accept_id', $accept_id['RiskMitigationStrategy']['id'] );
		$this->set( 'transfer_id', $transfer_id['RiskMitigationStrategy']['id'] );
		$this->set( 'users', $users );
	}

	private function initAddEditSubtitle() {
		$this->set( 'subtitle_for_layout', __( 'Feared by many, impractical for others, loved for some. Most regulations are very strict in requesting a Risk Management framework being tailor made developed and used by any Security Program. This sections aims to aid on keeping track of such program, at least in it\'s most minimalistic way.' ) );
	}

}
?>