<?php
class RiskExceptionsController extends AppController {
	public $helpers = array( 'Html', 'Form' );
	public $components = array( 'Session' );

	public function index() {
		$this->set( 'title_for_layout', __( 'Risk Exception Management' ) );
		$this->set( 'subtitle_for_layout', __( 'Defining Risk Exceptions is one way to accept Risks when their mitigation is not viable.' ) );

		$this->paginate = array(
			'conditions' => array(
			),
			'fields' => array(
				//'Legal.id', 'Legal.name', 'Legal.description', 'Legal.risk_magnifier'
			),
			'order' => array('RiskException.id' => 'ASC'),
			'limit' => $this->getPageLimit(),
			'recursive' => 0
		);

		$data = $this->paginate( 'RiskException' );
		$this->set( 'data', $data );
	}

	public function delete( $id = null ) {
		$data = $this->RiskException->find( 'count', array(
			'conditions' => array(
				'RiskException.id' => $id
			)
		) );

		if ( empty( $data ) ) {
			throw new NotFoundException();
		}

		$this->RiskException->delete( $id );

		$this->Session->setFlash( __( 'Risk Exception was successfully deleted.' ), FLASH_OK );
		$this->redirect( array( 'controller' => 'riskExceptions', 'action' => 'index' ) );
	}

	public function add() {
		$this->set( 'title_for_layout', __( 'Create a Risk Exception' ) );
		$this->initAddEditSubtitle();
		
		if ( $this->request->is( 'post' ) ) {
			unset( $this->request->data['RiskException']['id'] );

			$this->RiskException->set( $this->request->data );

			if ( $this->RiskException->validates() ) {
				$this->RiskException->query( 'SET autocommit = 0' );
				$this->RiskException->begin();

				$save1 = $this->RiskException->save();
				$save2 = $this->joinSecurityPolicies( $this->request->data['RiskException']['security_policy_id'], $this->RiskException->id );

				if ( $save1 && $save2 ) {
					$this->RiskException->commit();

					$this->Session->setFlash( __( 'Risk Exception was successfully added.' ), FLASH_OK );
					$this->redirect( array( 'controller' => 'riskExceptions', 'action' => 'index' ) );
				} else {
					$this->RiskException->rollback();
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
			$id = (int) $this->request->data['RiskException']['id'];
		}

		$data = $this->RiskException->find( 'first', array(
			'conditions' => array(
				'RiskException.id' => $id
			),
			'recursive' => 1
		) );

		if ( empty( $data ) ) {
			throw new NotFoundException();
		}

		$this->set( 'edit', true );
		$this->set( 'title_for_layout', __( 'Edit a Risk Exception' ) );
		$this->initAddEditSubtitle();
		
		if ( $this->request->is( 'post' ) || $this->request->is( 'put' ) ) {

			$this->RiskException->set( $this->request->data );

			if ( $this->RiskException->validates() ) {
				$this->RiskException->query( 'SET autocommit = 0' );
				$this->RiskException->begin();

				$delete = $this->RiskException->RiskExceptionsSecurityPolicy->deleteAll( array(
					'RiskExceptionsSecurityPolicy.risk_exception_id' => $id
				) );
				$save1 = $this->RiskException->save();
				$save2 = $this->joinSecurityPolicies( $this->request->data['RiskException']['security_policy_id'], $this->RiskException->id );

				if ( $delete && $save1 && $save2 ) {
					$this->RiskException->commit();

					$this->Session->setFlash( __( 'Risk Exception was successfully edited.' ), FLASH_OK );
					$this->redirect( array( 'controller' => 'riskExceptions', 'action' => 'index', $id ) );
				}
				else {
					$this->RiskException->rollback();
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

	private function joinSecurityPolicies( $list, $risk_exception_id ) {
		if ( ! is_array( $list ) ) {
			return true;
		}
		
		foreach ( $list as $id ) {
			$tmp = array(
				'risk_exception_id' => $risk_exception_id,
				'security_policy_id' => $id
			);

			$this->RiskException->RiskExceptionsSecurityPolicy->create();
			if ( ! $this->RiskException->RiskExceptionsSecurityPolicy->save( $tmp ) ) {
				return false;
			}
		}

		return true;
	}

	private function initOptions() {
		$security_policies = $this->getSecurityPoliciesList();

		$this->set( 'security_policies', $security_policies );
	}

	private function initAddEditSubtitle() {
		$this->set( 'subtitle_for_layout', __( 'Risk Exceptions are very usefull at the time of accepting a known risk. Once approved, they provide substantiation to Risk items.' ) );
	}

}
?>