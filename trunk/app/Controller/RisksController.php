<?php
class RisksController extends AppController {
	public $helpers = array( 'Html', 'Form' );
	public $components = array( 'Session' );

	public function index() {
		$this->set( 'title_for_layout', __( 'Asset based - Risk Analysis' ) );
		$this->set( 'subtitle_for_layout', __( 'Identifying and analysing Risks can be usefull if executed in a simple and practical way. For each asset identify and analyse risks.' ) );

		$this->paginate = array(
			'conditions' => array(
			),
			'fields' => array(
				//'Legal.id', 'Legal.name', 'Legal.description', 'Legal.risk_magnifier'
			),
			'order' => array('Risk.id' => 'ASC'),
			'limit' => $this->getPageLimit(),
			'recursive' => 0
		);

		$data = $this->paginate( 'Risk' );
		$this->set( 'data', $data );
	}

	public function delete( $id = null ) {
		$data = $this->Risk->find( 'count', array(
			'conditions' => array(
				'Risk.id' => $id
			)
		) );

		if ( empty( $data ) ) {
			throw new NotFoundException();
		}

		$this->Risk->delete( $id );
		$this->deleteJoins( $id );

		$this->Session->setFlash( __( 'Risk was successfully deleted.' ), FLASH_OK );
		$this->redirect( array( 'controller' => 'risks', 'action' => 'index' ) );
	}

	public function add() {
		$this->set( 'title_for_layout', __( 'Create a Risk' ) );
		$this->initAddEditSubtitle();
		
		if ( $this->request->is( 'post' ) ) {
			unset( $this->request->data['Risk']['id'] );

			$this->Risk->set( $this->request->data );

			if ( $this->Risk->validates() ) {
				if ( $this->Risk->save() ) {
					$this->joinAssetsRisks( $this->request->data['Risk']['asset_id'], $this->Risk->id );
					$this->joinRisksThreats( $this->request->data['Risk']['threat_id'], $this->Risk->id );
					$this->joinRisksVulnerabilities( $this->request->data['Risk']['vulnerability_id'], $this->Risk->id );

					if ( isset( $this->request->data['Risk']['security_service_id'] ) ) {
						$this->joinRisksSecurityServices( $this->request->data['Risk']['security_service_id'], $this->Risk->id );
					}

					if ( isset( $this->request->data['Risk']['risk_exception_id'] ) ) {
						$this->joinRisksRiskExceptions( $this->request->data['Risk']['risk_exception_id'], $this->Risk->id );
					}

					$this->Session->setFlash( __( 'Risk was successfully added.' ), FLASH_OK );
					$this->redirect( array( 'controller' => 'risks', 'action' => 'index' ) );
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
	 * Join Assets and Risks.
	 * @param  array   $list    Asset IDs list.
	 * @param  integer $risk_id Risk ID.
	 */
	private function joinAssetsRisks( $list, $risk_id ) {
		foreach ( $list as $id ) {
			$tmp = array(
				'risk_id' => $risk_id,
				'asset_id' => $id
			);

			$this->Risk->AssetsRisk->create();
			$this->Risk->AssetsRisk->save( $tmp );
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
				'risk_id' => $risk_id,
				'threat_id' => $id
			);

			$this->Risk->RisksThreat->create();
			$this->Risk->RisksThreat->save( $tmp );
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
				'risk_id' => $risk_id,
				'vulnerability_id' => $id
			);

			$this->Risk->RisksVulnerability->create();
			$this->Risk->RisksVulnerability->save( $tmp );
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
				'risk_id' => $risk_id,
				'security_service_id' => $id
			);

			$this->Risk->RisksSecurityService->create();
			$this->Risk->RisksSecurityService->save( $tmp );
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
				'risk_id' => $risk_id,
				'risk_exception_id' => $id
			);

			$this->Risk->RiskExceptionsRisk->create();
			$this->Risk->RiskExceptionsRisk->save( $tmp );
		}
	}

	/**
	 * Delete all many to many joins in related tables.
	 * @param  integer $id Risk ID
	 */
	private function deleteJoins( $id ) {
		$this->Risk->AssetsRisk->deleteAll( array(
			'AssetsRisk.risk_id' => $id
		) );

		$this->Risk->RisksThreat->deleteAll( array(
			'RisksThreat.risk_id' => $id
		) );

		$this->Risk->RisksVulnerability->deleteAll( array(
			'RisksVulnerability.risk_id' => $id
		) );

		$this->Risk->RisksSecurityService->deleteAll( array(
			'RisksSecurityService.risk_id' => $id
		) );

		$this->Risk->RiskExceptionsRisk->deleteAll( array(
			'RiskExceptionsRisk.risk_id' => $id
		) );
	}

	/**
	 * Initialize options for join elements.
	 */
	private function initOptions() {
		$types = $this->Risk->RiskClassification->find('list', array(
			'order' => array('RiskClassification.name' => 'ASC'),
			'recursive' => -1
		));

		$strategies = $this->Risk->RiskMitigationStrategy->find('list', array(
			'order' => array('RiskMitigationStrategy.name' => 'ASC'),
			'recursive' => -1
		));

		$assets = $this->Risk->Asset->find('list', array(
			'order' => array('Asset.name' => 'ASC'),
			'recursive' => -1
		));

		$threats = $this->Risk->Threat->find('list', array(
			'order' => array('Threat.name' => 'ASC'),
			'recursive' => -1
		));

		$vulnerabilities = $this->Risk->Vulnerability->find('list', array(
			'order' => array('Vulnerability.name' => 'ASC'),
			'recursive' => -1
		));

		$services = $this->Risk->SecurityService->find('list', array(
			'order' => array('SecurityService.name' => 'ASC'),
			'recursive' => -1
		));

		$risk_exceptions = $this->Risk->RiskException->find('list', array(
			'order' => array('RiskException.title' => 'ASC'),
			'recursive' => -1
		));

		$mitigate_id = $this->Risk->RiskMitigationStrategy->find( 'first', array(
			'conditions' => array(
				'RiskMitigationStrategy.type' => RISK_MITIGATION_MITIGATE
			),
			'recursive' => -1
		) );
		
		$accept_id = $this->Risk->RiskMitigationStrategy->find( 'first', array(
			'conditions' => array(
				'RiskMitigationStrategy.type' => RISK_MITIGATION_ACCEPT
			),
			'recursive' => -1
		) );

		$transfer_id = $this->Risk->RiskMitigationStrategy->find( 'first', array(
			'conditions' => array(
				'RiskMitigationStrategy.type' => RISK_MITIGATION_TRANSFER
			),
			'recursive' => -1
		) );

		$this->set( 'types', $types );
		$this->set( 'strategies', $strategies );
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