<?php
class PolicyExceptionsController extends AppController {
	public $helpers = array( 'Html', 'Form' );
	public $components = array( 'Session' );

	public function index() {
		$this->set( 'title_for_layout', __( 'Policy Exceptions' ) );
		$this->set( 'subtitle_for_layout', __( 'Records for all reported Policy Exceptions.' ) );

		$this->paginate = array(
			'conditions' => array(
			),
			'fields' => array(
			),
			'order' => array('PolicyException.id' => 'ASC'),
			'limit' => $this->getPageLimit(),
			'recursive' => 0
		);

		$data = $this->paginate( 'PolicyException' );
		$this->set( 'data', $data );
	}

	public function delete( $id = null ) {
		$data = $this->PolicyException->find( 'count', array(
			'conditions' => array(
				'PolicyException.id' => $id
			)
		) );

		if ( empty( $data ) ) {
			throw new NotFoundException();
		}

		$this->PolicyException->delete( $id );

		$this->Session->setFlash( __( 'Policy Exception was successfully deleted.' ), FLASH_OK );
		$this->redirect( array( 'controller' => 'policyExceptions', 'action' => 'index' ) );
	}

	public function add() {
		$this->set( 'title_for_layout', __( 'Create a Policy Exception' ) );
		$this->initAddEditSubtitle();
		
		if ( $this->request->is( 'post' ) ) {
			unset( $this->request->data['PolicyException']['id'] );

			$this->PolicyException->set( $this->request->data );

			if ( $this->PolicyException->validates() ) {
				if ( $this->PolicyException->save() ) {
					$this->Session->setFlash( __( 'Policy Exception was successfully added.' ), FLASH_OK );
					$this->redirect( array( 'controller' => 'policyExceptions', 'action' => 'index' ) );
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
			$id = (int) $this->request->data['PolicyException']['id'];
		}

		$data = $this->PolicyException->find( 'first', array(
			'conditions' => array(
				'PolicyException.id' => $id
			),
			'recursive' => -1
		) );

		if ( empty( $data ) ) {
			throw new NotFoundException();
		}

		$this->set( 'edit', true );
		$this->set( 'title_for_layout', __( 'Edit a Policy Exception' ) );
		$this->initAddEditSubtitle();
		
		if ( $this->request->is( 'post' ) || $this->request->is( 'put' ) ) {

			$this->PolicyException->set( $this->request->data );

			if ( $this->PolicyException->validates() ) {
				if ( $this->PolicyException->save() ) {
					$this->Session->setFlash( __( 'Policy Exception was successfully edited.' ), FLASH_OK );
					$this->redirect( array( 'controller' => 'policyExceptions', 'action' => 'index', $id ) );
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
	 * Initialize options for join elements.
	 */
	private function initOptions() {
		$statuses = $this->PolicyException->PolicyExceptionStatus->find('list', array(
			'order' => array('PolicyExceptionStatus.name' => 'ASC'),
			'recursive' => -1
		));

		$this->set( 'statuses', $statuses );
	}

	private function initAddEditSubtitle() {
		$this->set( 'subtitle_for_layout', __( 'Use this form to create or edit a Policy Exception.' ) );
	}

}
?>