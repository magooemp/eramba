<?php
class ProcessesController extends AppController {
	public $helpers = array( 'Html', 'Form' );
	public $components = array( 'Session' );

	public function delete( $id = null ) {
		$data = $this->Process->find( 'count', array(
			'conditions' => array(
				'Process.id' => $id
			)
		) );

		if ( empty( $data ) ) {
			throw new NotFoundException();
		}

		if ( $this->Process->delete( $id ) ) {
			$this->Session->setFlash( __( 'Business Process was successfully deleted.' ), FLASH_OK );
		} else {
			$this->Session->setFlash( __( 'Error while deleting the data. Please try it again.' ), FLASH_ERROR );
		}

		$this->redirect( array( 'controller' => 'businessUnits', 'action' => 'index' ) );
	}

	public function add( $bu_id = null ) {
		$bu_id = (int) $bu_id;

		$this->set( 'title_for_layout', __( 'Create a Business Process' ) );
		$this->initAddEditSubtitle();
		
		if ( $this->request->is( 'post' ) ) {
			unset( $this->request->data['Process']['id'] );

			$this->Process->set( $this->request->data );

			if ( $this->Process->validates() ) {
				if ( $this->Process->save() ) {
					$this->Session->setFlash( __( 'Business Process was successfully added.' ), FLASH_OK );
					$this->redirect( array( 'controller' => 'businessUnits', 'action' => 'index' ) );
				} else {
					$this->Session->setFlash( __( 'Error while saving the data. Please try it again.' ), FLASH_ERROR );
				}
			} else {
				$this->Session->setFlash( __( 'One or more inputs you entered are invalid. Please try again.' ), FLASH_ERROR );
			}
		} else {
			$bu_data = $this->Process->BusinessUnit->find( 'first', array(
				'conditions' => array(
					'BusinessUnit.id' => $bu_id
				),
				'recursive' => -1
			) );

			if ( empty( $bu_data ) ) {
				throw new NotFoundException();
			}
		}

		$this->set( 'bu_id', $bu_id );
	}

	public function edit( $id = null ) {
		$id = (int) $id;

		if ( ! empty( $this->request->data ) ) {
			$id = (int) $this->request->data['Process']['id'];
		}

		$data = $this->Process->find( 'first', array(
			'conditions' => array(
				'Process.id' => $id
			),
			'recursive' => -1
		) );

		if ( empty( $data ) ) {
			throw new NotFoundException();
		}

		$this->set( 'edit', true );
		$this->set( 'title_for_layout', __( 'Edit a Business Process' ) );
		$this->initAddEditSubtitle();
		
		if ( $this->request->is( 'post' ) || $this->request->is( 'put' ) ) {

			$this->Process->set( $this->request->data );

			if ( $this->Process->validates() ) {
				
				if ( $this->Process->save() ) {
					$this->Session->setFlash( __( 'Business Process was successfully edited.' ), FLASH_OK );
					$this->redirect( array( 'controller' => 'businessUnits', 'action' => 'index', $id ) );
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
		$this->set( 'subtitle_for_layout', __( 'Describe the main functions of each Business Unit. There shouldnt be more than three or four. If you dare going too much in detail you might exponentially increase the task of understanding your organization and all that level of detail might not bring substantial value. Start small.' ) );
	}

}