<?php
class ThirdPartyRisksController extends AppController {
	public $helpers = array( 'Html', 'Form' );
	public $components = array( 'Session' );

	public function index() {
		$this->set( 'title_for_layout', __( 'Third Party - Risk Analysis' ) );
		$this->set( 'subtitle_for_layout', __( 'Identifying and analysing Risks can be usefull if executed in a simple and practical way. For each Third Party identify and analyse risks.' ) );

		$this->paginate = array(
			'conditions' => array(
			),
			'fields' => array(
				//'Legal.id', 'Legal.name', 'Legal.description', 'Legal.risk_magnifier'
			),
			'order' => array('ThirdPartyRisk.id' => 'ASC'),
			'limit' => $this->getPageLimit(),
			'recursive' => 0
		);

		$data = $this->paginate( 'ThirdPartyRisk' );
		$this->set( 'data', $data );
	}

	public function delete( $id = null ) {
		$data = $this->ThirdPartyRisk->find( 'count', array(
			'conditions' => array(
				'ThirdPartyRisk.id' => $id
			)
		) );

		if ( empty( $data ) ) {
			throw new NotFoundException();
		}

		$this->ThirdPartyRisk->delete( $id );
		$this->deleteJoins( $id );

		$this->Session->setFlash( __( 'Third Party Risk was successfully deleted.' ), FLASH_OK );
		$this->redirect( array( 'controller' => 'thirdPartyRisks', 'action' => 'index' ) );
	}

	public function add() {
		$this->set( 'title_for_layout', __( 'Create a Third Party Risk' ) );
		$this->initAddEditSubtitle();
		
		if ( $this->request->is( 'post' ) ) {
			unset( $this->request->data['ThirdPartyRisk']['id'] );

			$this->request->data['ThirdPartyRisk']['risk_classification_id'] = $this->fixClassificationIds();

			$risk_score = $this->calculateRiskScore();
			$this->request->data['ThirdPartyRisk']['risk_score'] = $risk_score;

			$this->ThirdPartyRisk->set( $this->request->data );

			if ( $this->ThirdPartyRisk->validates() ) {
				$this->ThirdPartyRisk->query( 'SET autocommit = 0' );
				$this->ThirdPartyRisk->begin();

				$save1 = $this->ThirdPartyRisk->save();
				$save2 = $this->joinRisksThirdParties( $this->request->data['ThirdPartyRisk']['third_party_id'], $this->ThirdPartyRisk->id );
				$save3 = $this->joinAssetsRisks( $this->request->data['ThirdPartyRisk']['asset_id'], $this->ThirdPartyRisk->id );
				$save4 = $this->joinRisksThreats( $this->request->data['ThirdPartyRisk']['threat_id'], $this->ThirdPartyRisk->id );
				$save5 = $this->joinRisksVulnerabilities( $this->request->data['ThirdPartyRisk']['vulnerability_id'], $this->ThirdPartyRisk->id );
				if ( isset( $this->request->data['ThirdPartyRisk']['security_service_id'] ) ) {
					$save6 = $this->joinRisksSecurityServices( $this->request->data['ThirdPartyRisk']['security_service_id'], $this->ThirdPartyRisk->id );
				} else {
					$save6 = true;
				}
				if ( isset( $this->request->data['ThirdPartyRisk']['risk_exception_id'] ) ) {
					$save7 = $this->joinRisksRiskExceptions( $this->request->data['ThirdPartyRisk']['risk_exception_id'], $this->ThirdPartyRisk->id );
				} else {
					$save7 = true;
				}
				$save8 = $this->joinRiskClassifications( $this->request->data['ThirdPartyRisk']['risk_classification_id'], $this->ThirdPartyRisk->id );

				if ( $save1 && $save2 && $save3 && $save4 && $save5 && $save6 && $save7 && $save8 ) {
					$this->ThirdPartyRisk->commit();

					$this->Session->setFlash( __( 'Third Party Risk was successfully added.' ), FLASH_OK );
					$this->redirect( array( 'controller' => 'thirdPartyRisks', 'action' => 'index' ) );
				} else {
					$this->ThirdPartyRisk->rollback();

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
			$id = (int) $this->request->data['ThirdPartyRisk']['id'];
		}

		$data = $this->ThirdPartyRisk->find( 'first', array(
			'conditions' => array(
				'ThirdPartyRisk.id' => $id
			),
			'recursive' => 1
		) );

		if ( empty( $data ) ) {
			throw new NotFoundException();
		}

		$this->set( 'edit', true );
		$this->set( 'title_for_layout', __( 'Edit a Risk' ) );
		$this->initAddEditSubtitle();
		
		if ( $this->request->is( 'post' ) || $this->request->is( 'put' ) ) {
			$this->request->data['ThirdPartyRisk']['risk_classification_id'] = $this->fixClassificationIds();

			$risk_score = $this->calculateRiskScore();
			$this->request->data['ThirdPartyRisk']['risk_score'] = $risk_score;

			$this->ThirdPartyRisk->set( $this->request->data );

			if ( $this->ThirdPartyRisk->validates() ) {
				$this->ThirdPartyRisk->query( 'SET autocommit = 0' );
				$this->ThirdPartyRisk->begin();

				$delete = $this->deleteJoins( $id );
				$save1 = $this->ThirdPartyRisk->save();
				$save2 = $this->joinRisksThirdParties( $this->request->data['ThirdPartyRisk']['third_party_id'], $this->ThirdPartyRisk->id );
				$save3 = $this->joinAssetsRisks( $this->request->data['ThirdPartyRisk']['asset_id'], $this->ThirdPartyRisk->id );
				$save4 = $this->joinRisksThreats( $this->request->data['ThirdPartyRisk']['threat_id'], $this->ThirdPartyRisk->id );
				$save5 = $this->joinRisksVulnerabilities( $this->request->data['ThirdPartyRisk']['vulnerability_id'], $this->ThirdPartyRisk->id );
				if ( isset( $this->request->data['ThirdPartyRisk']['security_service_id'] ) ) {
					$save6 = $this->joinRisksSecurityServices( $this->request->data['ThirdPartyRisk']['security_service_id'], $this->ThirdPartyRisk->id );
				} else {
					$save6 = true;
				}
				if ( isset( $this->request->data['ThirdPartyRisk']['risk_exception_id'] ) ) {
					$save7 = $this->joinRisksRiskExceptions( $this->request->data['ThirdPartyRisk']['risk_exception_id'], $this->ThirdPartyRisk->id );
				} else {
					$save7 = true;
				}

				$save8 = $this->joinRiskClassifications( $this->request->data['ThirdPartyRisk']['risk_classification_id'], $this->ThirdPartyRisk->id );

				if ( $delete && $save1 && $save2 && $save3 && $save4 && $save5 && $save6 && $save7 && $save8 ) {
					$this->ThirdPartyRisk->commit();

					$this->Session->setFlash( __( 'Third Party Risk was successfully edited.' ), FLASH_OK );
					$this->redirect( array( 'controller' => 'thirdPartyRisks', 'action' => 'index' ) );
				} else {
					$this->ThirdPartyRisk->rollback();

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
		foreach ( $this->request->data['ThirdPartyRisk']['risk_classification_id'] as $classification_id ) {
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
		$classification_ids = $this->request->data['ThirdPartyRisk']['risk_classification_id'];
		if ( empty( $classification_ids ) ) {
			return 0;
		}

		$classifications = $this->ThirdPartyRisk->RiskClassification->find('all', array(
			'conditions' => array(
				'RiskClassification.id' => $classification_ids
			),
			'fields' => array( 'id', 'value' ),
			'recursive' => -1
		));

		$asset_ids = $this->request->data['ThirdPartyRisk']['asset_id'];
		$assets = $this->ThirdPartyRisk->Asset->find('all', array(
			'conditions' => array(
				'Asset.id' => $asset_ids
			),
			'fields' => array( 'id' ),
			'contain' => array(
				'Legal' => array(
					'fields' => array( 'id', 'risk_magnifier' )
				)
			),
			'recursive' => 0
		));

		$classification_sum = 0;
		foreach ( $classifications as $classification ) {
			$classification_sum += $classification['RiskClassification']['value'];
		}

		$asset_sum = 0;
		foreach ( $assets as $asset ) {
			$asset_sum += $asset['Legal']['risk_magnifier'];
		}

		if ( $asset_sum ) {
			return $classification_sum * $asset_sum;
		}

		return $classification_sum;
	}

	/**
	 * Join Third Parties and Risks.
	 * @param  array   $list    Third Party IDs list.
	 * @param  integer $risk_id Risk ID.
	 */
	private function joinRisksThirdParties( $list, $risk_id ) {
		foreach ( $list as $id ) {
			$tmp = array(
				'third_party_risk_id' => $risk_id,
				'third_party_id' => $id
			);

			$this->ThirdPartyRisk->ThirdPartiesThirdPartyRisk->create();
			if ( ! $this->ThirdPartyRisk->ThirdPartiesThirdPartyRisk->save( $tmp ) ) {
				return false;
			}
		}

		return true;
	}

	/**
	 * Join Assets and Risks.
	 * @param  array   $list    Asset IDs list.
	 * @param  integer $risk_id Risk ID.
	 */
	private function joinAssetsRisks( $list, $risk_id ) {
		foreach ( $list as $id ) {
			$tmp = array(
				'third_party_risk_id' => $risk_id,
				'asset_id' => $id
			);

			$this->ThirdPartyRisk->AssetsThirdPartyRisk->create();
			if ( ! $this->ThirdPartyRisk->AssetsThirdPartyRisk->save( $tmp ) ) {
				return false;
			}
		}

		return true;
	}

	/**
	 * Join Risks and Threats.
	 * @param  array   $list    Threat IDs list.
	 * @param  integer $risk_id Risk ID.
	 */
	private function joinRisksThreats( $list, $risk_id ) {
		foreach ( $list as $id ) {
			$tmp = array(
				'third_party_risk_id' => $risk_id,
				'threat_id' => $id
			);

			$this->ThirdPartyRisk->ThirdPartyRisksThreat->create();
			if ( ! $this->ThirdPartyRisk->ThirdPartyRisksThreat->save( $tmp ) ) {
				return false;
			}
		}

		return true;
	}

	/**
	 * Join Risks and Vulnerabilities.
	 * @param  array   $list    Vulnerability IDs list.
	 * @param  integer $risk_id Risk ID.
	 */
	private function joinRisksVulnerabilities( $list, $risk_id ) {
		foreach ( $list as $id ) {
			$tmp = array(
				'third_party_risk_id' => $risk_id,
				'vulnerability_id' => $id
			);

			$this->ThirdPartyRisk->ThirdPartyRisksVulnerability->create();
			if ( ! $this->ThirdPartyRisk->ThirdPartyRisksVulnerability->save( $tmp ) ) {
				return false;
			}
		}

		return true;
	}

	/**
	 * Join Risks and Security Services.
	 * @param  array   $list    Security Service IDs list.
	 * @param  integer $risk_id Risk ID.
	 */
	private function joinRisksSecurityServices( $list, $risk_id ) {
		foreach ( $list as $id ) {
			$tmp = array(
				'third_party_risk_id' => $risk_id,
				'security_service_id' => $id
			);

			$this->ThirdPartyRisk->SecurityServicesThirdPartyRisk->create();
			if ( ! $this->ThirdPartyRisk->SecurityServicesThirdPartyRisk->save( $tmp ) ) {
				return false;
			}
		}

		return true;
	}

	/**
	 * Join Risks and Risk Exceptions.
	 * @param  array   $list    Risk Exception IDs list.
	 * @param  integer $risk_id Risk ID.
	 */
	private function joinRisksRiskExceptions( $list, $risk_id ) {
		foreach ( $list as $id ) {
			$tmp = array(
				'third_party_risk_id' => $risk_id,
				'risk_exception_id' => $id
			);

			$this->ThirdPartyRisk->RiskExceptionsThirdPartyRisk->create();
			if ( ! $this->ThirdPartyRisk->RiskExceptionsThirdPartyRisk->save( $tmp ) ) {
				return false;
			}

			return true;
		}
	}

	private function joinRiskClassifications( $list, $risk_id ) {
		if ( ! is_array( $list ) || empty( $list ) ) {
			return true;
		}
		
		foreach ( $list as $risk_classification_id ) {
			if ( ! $risk_classification_id )
				continue;

			$tmp = array(
				'third_party_risk_id' => $risk_id,
				'risk_classification_id' => $risk_classification_id
			);

			$this->ThirdPartyRisk->RiskClassificationsThirdPartyRisk->create();
			if ( ! $this->ThirdPartyRisk->RiskClassificationsThirdPartyRisk->save( $tmp ) ) {
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
		$delete1 = $this->ThirdPartyRisk->ThirdPartiesThirdPartyRisk->deleteAll( array(
			'ThirdPartiesThirdPartyRisk.third_party_risk_id' => $id
		) );

		$delete2 = $this->ThirdPartyRisk->AssetsThirdPartyRisk->deleteAll( array(
			'AssetsThirdPartyRisk.third_party_risk_id' => $id
		) );

		$delete3 = $this->ThirdPartyRisk->ThirdPartyRisksThreat->deleteAll( array(
			'ThirdPartyRisksThreat.third_party_risk_id' => $id
		) );

		$delete4 = $this->ThirdPartyRisk->ThirdPartyRisksVulnerability->deleteAll( array(
			'ThirdPartyRisksVulnerability.third_party_risk_id' => $id
		) );

		$delete5 = $this->ThirdPartyRisk->SecurityServicesThirdPartyRisk->deleteAll( array(
			'SecurityServicesThirdPartyRisk.third_party_risk_id' => $id
		) );

		$delete6 = $this->ThirdPartyRisk->RiskExceptionsThirdPartyRisk->deleteAll( array(
			'RiskExceptionsThirdPartyRisk.third_party_risk_id' => $id
		) );

		$delete7 = $this->ThirdPartyRisk->RiskClassificationsThirdPartyRisk->deleteAll( array(
			'RiskClassificationsThirdPartyRisk.third_party_risk_id' => $id
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

		$strategies = $this->ThirdPartyRisk->RiskMitigationStrategy->find('list', array(
			'order' => array('RiskMitigationStrategy.name' => 'ASC'),
			'recursive' => -1
		));

		$third_parties = $this->ThirdPartyRisk->ThirdParty->find('list', array(
			'order' => array('ThirdParty.name' => 'ASC'),
			'recursive' => -1
		));

		$assets = $this->ThirdPartyRisk->Asset->find('list', array(
			'order' => array('Asset.name' => 'ASC'),
			'recursive' => -1
		));

		$threats = $this->ThirdPartyRisk->Threat->find('list', array(
			'order' => array('Threat.name' => 'ASC'),
			'recursive' => -1
		));

		$vulnerabilities = $this->ThirdPartyRisk->Vulnerability->find('list', array(
			'order' => array('Vulnerability.name' => 'ASC'),
			'recursive' => -1
		));

		$services = $this->ThirdPartyRisk->SecurityService->find('list', array(
			'order' => array('SecurityService.name' => 'ASC'),
			'recursive' => -1
		));

		$risk_exceptions = $this->ThirdPartyRisk->RiskException->find('list', array(
			'order' => array('RiskException.title' => 'ASC'),
			'recursive' => -1
		));

		$mitigate_id = $this->ThirdPartyRisk->RiskMitigationStrategy->find( 'first', array(
			'conditions' => array(
				'RiskMitigationStrategy.type' => RISK_MITIGATION_MITIGATE
			),
			'recursive' => -1
		) );
		
		$accept_id = $this->ThirdPartyRisk->RiskMitigationStrategy->find( 'first', array(
			'conditions' => array(
				'RiskMitigationStrategy.type' => RISK_MITIGATION_ACCEPT
			),
			'recursive' => -1
		) );

		$transfer_id = $this->ThirdPartyRisk->RiskMitigationStrategy->find( 'first', array(
			'conditions' => array(
				'RiskMitigationStrategy.type' => RISK_MITIGATION_TRANSFER
			),
			'recursive' => -1
		) );

		$users = $this->getUsersList();

		$this->set( 'classifications', $classifications );
		$this->set( 'strategies', $strategies );
		$this->set( 'third_parties', $third_parties );
		$this->set( 'assets', $assets );
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