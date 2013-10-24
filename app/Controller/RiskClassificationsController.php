<?php
class RiskClassificationsController extends AppController {
	public $helpers = array( 'Html', 'Form' );
	public $components = array( 'Session' );

	public function index() {
		$this->set( 'title_for_layout', __( 'Risk Classification' ) );
		$this->set( 'subtitle_for_layout', __( 'As part of the process of managing Risks, the classification of them is a critical componenent to set clear priorities and leverage from the Risk analsys. Define your Risk classification criterias in a usefull way!' ) );

		$this->paginate = array(
			'conditions' => array(
			),
			'fields' => array(
				'RiskClassification.id',
				'RiskClassification.name',
				'RiskClassification.criteria',
				'RiskClassification.value',
				'RiskClassificationType.name'
			),
			'order' => array('RiskClassification.id' => 'ASC'),
			'limit' => $this->getPageLimit(),
			'recursive' => 0
		);

		$data = $this->paginate( 'RiskClassification' );
		$this->set( 'data', $data );
	}

	public function delete( $id = null ) {
		$data = $this->RiskClassification->find( 'count', array(
			'conditions' => array(
				'RiskClassification.id' => $id
			)
		) );

		if ( empty( $data ) ) {
			throw new NotFoundException();
		}

		$this->RiskClassification->delete( $id );

		$this->Session->setFlash( __( 'Risk Classification was successfully deleted.' ), FLASH_OK );
		$this->redirect( array( 'controller' => 'riskClassifications', 'action' => 'index' ) );
	}

	public function add() {
		$this->set( 'title_for_layout', __( 'Create a Risk Classification' ) );
		$this->initAddEditSubtitle();
		
		if ( $this->request->is( 'post' ) ) {
			unset( $this->request->data['RiskClassification']['id'] );

			$this->processSubmit( __( 'Risk Classification was successfully added.' ) );
		}

		$this->initTypes();
	}

	public function edit( $id = null ) {
		$id = (int) $id;

		if ( ! empty( $this->request->data ) ) {
			$id = (int) $this->request->data['RiskClassification']['id'];
		}

		$data = $this->RiskClassification->find( 'first', array(
			'conditions' => array(
				'RiskClassification.id' => $id
			),
			'recursive' => -1
		) );

		if ( empty( $data ) ) {
			throw new NotFoundException();
		}

		$this->set( 'edit', true );
		$this->set( 'title_for_layout', __( 'Edit a Risk Classification' ) );
		$this->initAddEditSubtitle();
		
		if ( $this->request->is( 'post' ) || $this->request->is( 'put' ) ) {
			$this->processSubmit( __( 'Risk Classification was successfully edited.' ) );
		}
		else {
			$this->request->data = $data;
		}

		$this->initTypes();
		$this->render( 'add' );
	}

	private function processSubmit( $flashMessage = '' ) {
		if ( $this->request->data['RiskClassification']['risk_classification_type_id'] == '' ) {
			$this->RiskClassification->RiskClassificationType->set( $this->request->data );

			if ( $this->RiskClassification->RiskClassificationType->validates() ) {

				if ( $this->RiskClassification->RiskClassificationType->save() ) {
					$this->request->data['RiskClassification']['risk_classification_type_id'] = $this->RiskClassification->RiskClassificationType->id;

					$this->RiskClassification->set( $this->request->data );

					if ( $this->RiskClassification->validates() ) {
						if ( $this->RiskClassification->save() ) {
							$this->Session->setFlash( $flashMessage, FLASH_OK );
							$this->redirect( array( 'controller' => 'riskClassifications', 'action' => 'index' ) );
						} else {
							$this->Session->setFlash( __( 'Error while saving the data. Please try it again.' ), FLASH_ERROR );
						}
					} else {
						$this->Session->setFlash( __( 'One or more inputs you entered are invalid. Please try again.' ), FLASH_ERROR );
					}

				} else {
					$this->Session->setFlash( __( 'Error while saving the data. Please try it again.' ), FLASH_ERROR );
				}

			} else {
				$this->Session->setFlash( __( 'One or more inputs you entered are invalid. Please try again.' ), FLASH_ERROR );
			}

		} else {
			$this->RiskClassification->set( $this->request->data );

			if ( $this->RiskClassification->validates() ) {
				if ( $this->RiskClassification->save() ) {
					$this->Session->setFlash( __( 'Risk Classification was successfully added.' ), FLASH_OK );
					$this->redirect( array( 'controller' => 'riskClassifications', 'action' => 'index' ) );
				} else {
					$this->Session->setFlash( __( 'Error while saving the data. Please try it again.' ), FLASH_ERROR );
				}
			} else {
				$this->Session->setFlash( __( 'One or more inputs you entered are invalid. Please try again.' ), FLASH_ERROR );
			}
		}
	}

	private function initAddEditSubtitle() {
		$this->set( 'subtitle_for_layout', __( 'Usually there\'s many assets around in a organization. Trough classification (according to your needs) you will be able to set priorities and profile them in a way their treatment and handling is systematic. Btw, this is a basic requirement for most Security related regulations.' ) );
	}

	private function initTypes() {
		$types = $this->RiskClassification->RiskClassificationType->find('list', array(
			'order' => array('RiskClassificationType.name' => 'ASC'),
			'recursive' => -1
		));

		$this->set( 'types', $types );
	}

}
?>