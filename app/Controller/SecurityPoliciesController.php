<?php
class SecurityPoliciesController extends AppController {
	public $helpers = array( 'Html', 'Form' );
	public $components = array( 'Session' );

	public function index() {
		$this->set( 'title_for_layout', __( 'Security Policies' ) );
		$this->set( 'subtitle_for_layout', false );

		$this->paginate = array(
			'conditions' => array(
			),
			'fields' => array(
				
			),
			'order' => array('SecurityPolicy.id' => 'ASC'),
			'limit' => $this->getPageLimit(),
			'recursive' => 0
		);

		$data = $this->paginate( 'SecurityPolicy' );
		$this->set( 'data', $data );
		$this->initOptions();
	}

	public function delete( $id = null ) {
		$data = $this->SecurityPolicy->find( 'count', array(
			'conditions' => array(
				'SecurityPolicy.id' => $id
			)
		) );

		if ( empty( $data ) ) {
			throw new NotFoundException();
		}

		if ( $this->SecurityPolicy->delete( $id ) ) {
			$this->Session->setFlash( __( 'Security Policy was successfully deleted.' ), FLASH_OK );
		} else {
			$this->Session->setFlash( __( 'Error while deleting the data. Please try it again.' ), FLASH_ERROR );
		}

		$this->redirect( array( 'controller' => 'securityPolicies', 'action' => 'index' ) );
	}

	public function add() {
		$this->set( 'title_for_layout', __( 'Create a Security Policy' ) );
		$this->initAddEditSubtitle();
		
		if ( $this->request->is( 'post' ) ) {
			unset( $this->request->data['SecurityPolicy']['id'] );

			$this->SecurityPolicy->set( $this->request->data );

			if ( $this->SecurityPolicy->validates() ) {
				if ( $this->SecurityPolicy->save() ) {
					$this->Session->setFlash( __( 'Security Policy was successfully added.' ), FLASH_OK );
					$this->redirect( array( 'controller' => 'securityPolicies', 'action' => 'index' ) );
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
			$id = (int) $this->request->data['SecurityPolicy']['id'];
		}

		$data = $this->SecurityPolicy->find( 'first', array(
			'conditions' => array(
				'SecurityPolicy.id' => $id
			),
			'recursive' => -1
		) );

		if ( empty( $data ) ) {
			throw new NotFoundException();
		}

		$this->set( 'edit', true );
		$this->set( 'title_for_layout', __( 'Edit a Security Policy' ) );
		$this->initAddEditSubtitle();
		
		if ( $this->request->is( 'post' ) || $this->request->is( 'put' ) ) {

			$this->SecurityPolicy->set( $this->request->data );

			if ( $this->SecurityPolicy->validates() ) {
				if ( $this->SecurityPolicy->save() ) {
					$this->Session->setFlash( __( 'Security Policy was successfully edited.' ), FLASH_OK );
					$this->redirect( array( 'controller' => 'securityPolicies', 'action' => 'index', $id ) );
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
		$statuses = array(
			0 => __( 'Draft' ),
			1 => __( 'Released' )
		);

		$this->set( 'statuses', $statuses );
	}

	private function initAddEditSubtitle() {
		$this->set( 'subtitle_for_layout', __( false ) );
	}

}
?>