<?php
class ProjectsController extends AppController {
	public $helpers = array( 'Html', 'Form' );
	public $components = array( 'Session' );

	public function index() {
		$this->set( 'title_for_layout', __( 'Project Management' ) );
		$this->set( 'subtitle_for_layout', __( 'Manage your projects priorities, assignations, etc.' ) );

		$this->paginate = array(
			'conditions' => array(
			),
			'fields' => array(
				'Project.id',
				'Project.title',
				'ProjectStatus.name'
			),
			'order' => array( 'Project.id' => 'ASC' ),
			'limit' => $this->getPageLimit(),
			'recursive' => 0
		);

		$data = $this->paginate( 'Project' );
		$this->set( 'data', $data );

	}

	public function delete( $id = null ) {
		$data = $this->Project->find( 'count', array(
			'conditions' => array(
				'Project.id' => $id
			)
		) );

		if ( empty( $data ) ) {
			throw new NotFoundException();
		}

		$this->Project->delete( $id );

		$this->Session->setFlash( __( 'Project was successfully deleted.', FLASH_OK ) );
		$this->redirect( array( 'controller' => 'projects', 'action' => 'index' ) );
	}

	public function add() {
		$this->set( 'title_for_layout', __( 'Create a Third Party' ) );
		$this->initAddEditSubtitle();
		
		if ( $this->request->is( 'post' ) ) {
			unset( $this->request->data['Project']['id'] );

			$this->Project->set( $this->request->data );

			if ( $this->Project->validates() ) {
				if ( $this->Project->save() ) {
					$this->Session->setFlash( __( 'Project was successfully added.' ), FLASH_OK );
					$this->redirect( array( 'controller' => 'projects', 'action' => 'index' ) );
				} else {
					$this->Session->setFlash( __( 'Error while saving the data. Please try it again.', FLASH_ERROR ) );
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
			$id = (int) $this->request->data['Project']['id'];
		}

		$tp = $this->Project->find( 'first', array(
			'conditions' => array(
				'Project.id' => $id
			),
			'recursive' => -1
		) );

		if ( empty( $tp ) ) {
			throw new NotFoundException();
		}

		$this->set( 'edit', true );
		$this->set( 'title_for_layout', __( 'Edit a Project' ) );
		$this->initAddEditSubtitle();
		
		if ( $this->request->is( 'post' ) || $this->request->is( 'put' ) ) {

			$this->Project->set( $this->request->data );

			if ( $this->Project->validates() ) {
				
				if ( $this->Project->save() ) {
					$this->Session->setFlash( __( 'Project was successfully edited.' ), FLASH_OK );
					$this->redirect( array( 'controller' => 'projects', 'action' => 'index', $id ) );
				}
				else {
					$this->Session->setFlash( __( 'Error while saving the data. Please try it again.' ), FLASH_ERROR );
				}
			} else {
				$this->Session->setFlash( __( 'One or more inputs you entered are invalid. Please try again.' ), FLASH_ERROR );
			}
		}
		else {
			$this->request->data = $tp;
		}

		$this->initOptions();

		$this->render( 'add' );
	}

	private function initOptions() {
		$statuses = $this->Project->ProjectStatus->find('list', array(
			'order' => array('ProjectStatus.name' => 'ASC'),
			'recursive' => -1
		));
		
		$this->set( 'statuses', $statuses );
	}

	private function initAddEditSubtitle() {
		$this->set( 'subtitle_for_layout', __( 'Use this form to create or edit new improvement projects.' ) );
	}

}
?>