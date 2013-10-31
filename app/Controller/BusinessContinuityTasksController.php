<?php
class BusinessContinuityTasksController extends AppController {
	public $helpers = array( 'Html', 'Form' );
	public $components = array( 'Session' );

	public function delete( $id = null ) {
		$data = $this->BusinessContinuityTask->find( 'count', array(
			'conditions' => array(
				'BusinessContinuityTask.id' => $id
			)
		) );

		if ( empty( $data ) ) {
			throw new NotFoundException();
		}

		if ( $this->BusinessContinuityTask->delete( $id ) ) {
			$this->Session->setFlash( __( 'Business Continuity Task was successfully deleted.' ), FLASH_OK );
		} else {
			$this->Session->setFlash( __( 'Error while deleting the data. Please try it again.' ), FLASH_ERROR );
		}

		$this->redirect( array( 'controller' => 'businessContinuityPlans', 'action' => 'index' ) );
	}

	public function add( $id = null ) {
		$id = (int) $id;

		$this->set( 'title_for_layout', __( 'Create a Business Continuity Task' ) );
		$this->initAddEditSubtitle();
		
		if ( $this->request->is( 'post' ) ) {
			unset( $this->request->data['BusinessContinuityTask']['id'] );

			$this->BusinessContinuityTask->set( $this->request->data );

			if ( $this->BusinessContinuityTask->validates() ) {
				if ( $this->BusinessContinuityTask->save() ) {
					$this->Session->setFlash( __( 'Business Continuity Task was successfully added.' ), FLASH_OK );
					$this->redirect( array( 'controller' => 'businessContinuityPlans', 'action' => 'index' ) );
				} else {
					$this->Session->setFlash( __( 'Error while saving the data. Please try it again.' ), FLASH_ERROR );
				}
			} else {
				$this->Session->setFlash( __( 'One or more inputs you entered are invalid. Please try again.' ), FLASH_ERROR );
			}
		} else {
			$data = $this->BusinessContinuityTask->BusinessContinuityPlan->find( 'first', array(
				'conditions' => array(
					'BusinessContinuityPlan.id' => $id
				),
				'recursive' => -1
			) );

			if ( empty( $data ) ) {
				throw new NotFoundException();
			}
		}

		$this->set( 'id', $id );
	}

	public function edit( $id = null ) {
		$id = (int) $id;

		if ( ! empty( $this->request->data ) ) {
			$id = (int) $this->request->data['BusinessContinuityTask']['id'];
		}

		$data = $this->BusinessContinuityTask->find( 'first', array(
			'conditions' => array(
				'BusinessContinuityTask.id' => $id
			),
			'recursive' => -1
		) );

		if ( empty( $data ) ) {
			throw new NotFoundException();
		}

		$this->set( 'edit', true );
		$this->set( 'title_for_layout', __( 'Edit a Business Continuity Task' ) );
		$this->initAddEditSubtitle();
		
		if ( $this->request->is( 'post' ) || $this->request->is( 'put' ) ) {

			$this->BusinessContinuityTask->set( $this->request->data );

			if ( $this->BusinessContinuityTask->validates() ) {
				
				if ( $this->BusinessContinuityTask->save() ) {
					$this->Session->setFlash( __( 'Business Continuity Task was successfully edited.' ), FLASH_OK );
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

		$this->render( 'add' );
	}

	private function initAddEditSubtitle() {
		$this->set( 'subtitle_for_layout', __( 'This is the tools used to create an emergency plan. Emergency plans are short and very much to the point. Have you noticed aircraft emergency plans? there\'s no point in writing long manuals since at emergency times there\'s no time to read. Keep it to the point and you\'ll do fine.' ) );
	}

}