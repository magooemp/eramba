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
				//'BusinessUnit.id',
				//'BusinessUnit.name'
			),
			'order' => array( 'BusinessContinuityPlan.id' => 'ASC' ),
			'limit' => $this->getPageLimit(),
			'recursive' => 1
		);

		$data = $this->paginate( 'BusinessContinuityPlan' );
		$this->set( 'data', $data );
	}

	public function add() {
		$this->set( 'title_for_layout', __( 'Create a Business Continuity Plan' ) );
		$this->initAddEditSubtitle();
		
		if ( $this->request->is( 'post' ) ) {
			unset( $this->request->data['BusinessContinuityPlan']['id'] );

			$this->BusinessContinuityPlan->set( $this->request->data );

			if ( $this->BusinessContinuityPlan->validates() ) {
				if ( $this->BusinessContinuityPlan->save() ) {
					$this->Session->setFlash( __( 'Business Continuity Plan was successfully added.' ), FLASH_OK );
					$this->redirect( array( 'controller' => 'businessContinuityPlans', 'action' => 'index' ) );
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
			$id = (int) $this->request->data['BusinessContinuityPlan']['id'];
		}

		$data = $this->BusinessContinuityPlan->find( 'first', array(
			'conditions' => array(
				'BusinessContinuityPlan.id' => $id
			),
			'recursive' => -1
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
				
				if ( $this->BusinessContinuityPlan->save() ) {
					$this->Session->setFlash( __( 'Business Continuity Plan was successfully edited.' ), FLASH_OK );
					$this->redirect( array( 'controller' => 'businessContinuityPlans', 'action' => 'index', $id ) );
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
		$types = $this->BusinessContinuityPlan->SecurityServiceType->find('list', array(
			'order' => array('SecurityServiceType.name' => 'ASC'),
			'recursive' => -1
		));
		
		$this->set( 'types', $types );
	}

	private function initAddEditSubtitle() {
		$this->set( 'subtitle_for_layout', __( 'Use this form to create or edit a Continuity Plan.' ) );
	}

}