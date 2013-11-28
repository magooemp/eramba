<?php
class SecurityServiceMaintenancesController extends AppController {
	public $helpers = array( 'Html', 'Form' );
	public $components = array( 'Session' );

	public function index( $id = null ) {
		$this->set( 'title_for_layout', __( 'Security Services Maintenance Report' ) );
		$this->set( 'subtitle_for_layout', __( 'This is a report of all maintenance records for this service.' ) );

		$this->paginate = array(
			'conditions' => array(
				'SecurityServiceMaintenance.security_service_id' => $id
			),
			'fields' => array(
			),
			'order' => array('SecurityServiceMaintenance.id' => 'ASC'),
			'limit' => $this->getPageLimit(),
			'recursive' => 0
		);

		$data = $this->paginate( 'SecurityServiceMaintenance' );
		$this->set( 'data', $data );
		//debug( $data );
	}

	public function delete( $id = null ) {
		$data = $this->SecurityServiceMaintenance->find( 'count', array(
			'conditions' => array(
				'SecurityServiceMaintenance.id' => $id
			)
		) );

		if ( empty( $data ) ) {
			throw new NotFoundException();
		}

		if ( $this->SecurityServiceMaintenance->delete( $id ) ) {
			$this->Session->setFlash( __( 'Security Service Maintenance was successfully deleted.' ), FLASH_OK );
		} else {
			$this->Session->setFlash( __( 'Error while deleting the data. Please try it again.' ), FLASH_ERROR );
		}

		$this->redirect( array( 'controller' => 'securityServices', 'action' => 'index' ) );
	}

	/*public function add() {
		$this->set( 'title_for_layout', __( 'Create a Legal Constrain' ) );
		$this->initAddEditSubtitle();
		
		if ( $this->request->is( 'post' ) ) {
			unset( $this->request->data['Legal']['id'] );

			$this->Legal->set( $this->request->data );

			if ( $this->Legal->validates() ) {
				if ( $this->Legal->save() ) {
					$this->Session->setFlash( __( 'Legal Constrain was successfully added.' ), FLASH_OK );
					$this->redirect( array( 'controller' => 'legals', 'action' => 'index' ) );
				} else {
					$this->Session->setFlash( __( 'Error while saving the data. Please try it again.' ), FLASH_ERROR );
				}
			} else {
				$this->Session->setFlash( __( 'One or more inputs you entered are invalid. Please try again.' ), FLASH_ERROR );
			}
		}
	}
*/
	public function edit( $id = null ) {
		$id = (int) $id;

		if ( ! empty( $this->request->data ) ) {
			$id = (int) $this->request->data['SecurityServiceMaintenance']['id'];
		}

		$data = $this->SecurityServiceMaintenance->find( 'first', array(
			'conditions' => array(
				'SecurityServiceMaintenance.id' => $id
			),
			'recursive' => -1
		) );

		if ( empty( $data ) ) {
			throw new NotFoundException();
		}

		$this->set( 'edit', true );
		$this->set( 'title_for_layout', __( 'Edit a Security Service Maintenance' ) );
		$this->initAddEditSubtitle();
		
		if ( $this->request->is( 'post' ) || $this->request->is( 'put' ) ) {

			$this->SecurityServiceMaintenance->set( $this->request->data );

			if ( $this->SecurityServiceMaintenance->validates() ) {
				if ( $this->SecurityServiceMaintenance->save() ) {
					$this->Session->setFlash( __( 'Security Service Maintenance was successfully edited.' ), FLASH_OK );
					$this->redirect( array( 'controller' => 'securityServices', 'action' => 'index' ) );
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
		$users = $this->getUsersList();

		$this->set( 'users', $users );
	}


	private function initAddEditSubtitle() {
		$this->set( 'subtitle_for_layout', __( 'The objective is to keep track of the regular tasks Service Controls require in order to function properly.' ) );
	}

}
?>