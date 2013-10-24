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

			$this->ThirdPartyRisk->set( $this->request->data );

			if ( $this->ThirdPartyRisk->validates() ) {
				if ( $this->ThirdPartyRisk->save() ) {
					$this->joinRisksThirdParties( $this->request->data['ThirdPartyRisk']['third_party_id'], $this->ThirdPartyRisk->id );
					$this->joinAssetsRisks( $this->request->data['ThirdPartyRisk']['asset_id'], $this->ThirdPartyRisk->id );
					$this->joinRisksThreats( $this->request->data['ThirdPartyRisk']['threat_id'], $this->ThirdPartyRisk->id );
					$this->joinRisksVulnerabilities( $this->request->data['ThirdPartyRisk']['vulnerability_id'], $this->ThirdPartyRisk->id );

					if ( isset( $this->request->data['ThirdPartyRisk']['security_service_id'] ) ) {
						$this->joinRisksSecurityServices( $this->request->data['ThirdPartyRisk']['security_service_id'], $this->ThirdPartyRisk->id );
					}

					if ( isset( $this->request->data['ThirdPartyRisk']['risk_exception_id'] ) ) {
						$this->joinRisksRiskExceptions( $this->request->data['ThirdPartyRisk']['risk_exception_id'], $this->ThirdPartyRisk->id );
					}

					$this->Session->setFlash( __( 'Third Party Risk was successfully added.' ), FLASH_OK );
					$this->redirect( array( 'controller' => 'thirdPartyRisks', 'action' => 'index' ) );
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
			$id = (int) $this->request->data['Risk']['id'];
		}

		$data = $this->Risk->find( 'first', array(
			'conditions' => array(
				'Risk.id' => $id
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

			$this->Risk->set( $this->request->data );

			if ( $this->Risk->validates() ) {
				if ( $this->Risk->save() ) {
					$this->deleteJoins( $id );

					$this->joinAssetsRisks( $this->request->data['Risk']['asset_id'], $this->Risk->id );
					$this->joinRisksThreats( $this->request->data['Risk']['threat_id'], $this->Risk->id );
					$this->joinRisksVulnerabilities( $this->request->data['Risk']['vulnerability_id'], $this->Risk->id );

					if ( isset( $this->request->data['Risk']['security_service_id'] ) ) {
						$this->joinRisksSecurityServices( $this->request->data['Risk']['security_service_id'], $this->Risk->id );
					}

					if ( isset( $this->request->data['Risk']['risk_exception_id'] ) ) {
						$this->joinRisksRiskExceptions( $this->request->data['Risk']['risk_exception_id'], $this->Risk->id );
					}

					$this->Session->setFlash( __( 'Risk was successfully edited.' ), FLASH_OK );
					$this->redirect( array( 'controller' => 'risks', 'action' => 'index', $id ) );
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
			$this->ThirdPartyRisk->ThirdPartiesThirdPartyRisk->save( $tmp );
		}
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
			$this->ThirdPartyRisk->AssetsThirdPartyRisk->save( $tmp );
		}
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
			$this->ThirdPartyRisk->ThirdPartyRisksThreat->save( $tmp );
		}
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
			$this->ThirdPartyRisk->ThirdPartyRisksVulnerability->save( $tmp );
		}
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
			$this->ThirdPartyRisk->SecurityServicesThirdPartyRisk->save( $tmp );
		}
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
			$this->ThirdPartyRisk->RiskExceptionsThirdPartyRisk->save( $tmp );
		}
	}

	/**
	 * Delete all many to many joins in related tables.
	 * @param  integer $id Risk ID
	 */
	private function deleteJoins( $id ) {
		$this->ThirdPartyRisk->ThirdPartiesThirdPartyRisk->deleteAll( array(
			'ThirdPartiesThirdPartyRisk.third_party_risk_id' => $id
		) );

		$this->ThirdPartyRisk->AssetsThirdPartyRisk->deleteAll( array(
			'AssetsThirdPartyRisk.third_party_risk_id' => $id
		) );

		$this->ThirdPartyRisk->ThirdPartyRisksThreat->deleteAll( array(
			'ThirdPartyRisksThreat.third_party_risk_id' => $id
		) );

		$this->ThirdPartyRisk->ThirdPartyRisksVulnerability->deleteAll( array(
			'ThirdPartyRisksVulnerability.third_party_risk_id' => $id
		) );

		$this->ThirdPartyRisk->SecurityServicesThirdPartyRisk->deleteAll( array(
			'SecurityServicesThirdPartyRisk.third_party_risk_id' => $id
		) );

		$this->ThirdPartyRisk->RiskExceptionsThirdPartyRisk->deleteAll( array(
			'RiskExceptionsThirdPartyRisk.third_party_risk_id' => $id
		) );
	}

	/**
	 * Initialize options for join elements.
	 */
	private function initOptions() {
		$types = $this->ThirdPartyRisk->RiskClassification->find('list', array(
			'order' => array('RiskClassification.name' => 'ASC'),
			'recursive' => -1
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

		$this->set( 'types', $types );
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
	}

	private function initAddEditSubtitle() {
		$this->set( 'subtitle_for_layout', __( 'Feared by many, impractical for others, loved for some. Most regulations are very strict in requesting a Risk Management framework being tailor made developed and used by any Security Program. This sections aims to aid on keeping track of such program, at least in it\'s most minimalistic way.' ) );
	}

}
?>