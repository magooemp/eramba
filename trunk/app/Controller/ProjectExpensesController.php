<?php
class ProjectExpensesController extends AppController {
	public $helpers = array( 'Html', 'Form' );
	public $components = array( 'Session' );

	public function index( $project_id = null ) {
		$project_id = (int) $project_id;

		$this->set( 'title_for_layout', __( 'List of Expenses' ) );
		$this->set( 'subtitle_for_layout', __( 'This is the list of expenses for a given project.' ) );

		$this->paginate = array(
			'conditions' => array(
				'ProjectExpense.project_id' => $project_id
			),
			'fields' => array(
				//'Legal.id', 'Legal.name', 'Legal.description', 'Legal.risk_magnifier'
			),
			'order' => array('ProjectExpense.id' => 'ASC'),
			'limit' => $this->getPageLimit(),
			'recursive' => 0
		);

		$data = $this->paginate( 'ProjectExpense' );
		$this->set( 'data', $data );
		$this->set( 'project_id', $project_id );
	}

	public function delete( $id = null ) {
		$data = $this->ProjectExpense->find( 'count', array(
			'conditions' => array(
				'ProjectExpense.id' => $id
			)
		) );

		if ( empty( $data ) ) {
			throw new NotFoundException();
		}

		if ( $this->ProjectExpense->delete( $id ) ) {
			$this->Session->setFlash( __( 'Project Expense was successfully deleted.' ), FLASH_OK );
		} else {
			$this->Session->setFlash( __( 'Error while deleting the data. Please try it again.' ), FLASH_ERROR );
		}

		$this->redirect( array( 'controller' => 'projects', 'action' => 'index' ) );
	}

	public function add( $project_id = null ) {
		$project_id = (int) $project_id;

		$this->set( 'title_for_layout', __( 'Create a Project Expense' ) );
		$this->initAddEditSubtitle();
		
		if ( $this->request->is( 'post' ) ) {
			unset( $this->request->data['ProjectExpense']['id'] );

			$this->ProjectExpense->set( $this->request->data );

			if ( $this->ProjectExpense->validates() ) {
				if ( $this->ProjectExpense->save() ) {
					$this->Session->setFlash( __( 'Project Expense was successfully added.' ), FLASH_OK );
					$this->redirect( array( 'controller' => 'projects', 'action' => 'index' ) );
				} else {
					$this->Session->setFlash( __( 'Error while saving the data. Please try it again.' ), FLASH_ERROR );
				}
			} else {
				$this->Session->setFlash( __( 'One or more inputs you entered are invalid. Please try again.' ), FLASH_ERROR );
			}
		}

		$this->set( 'project_id', $project_id );
	}

	public function edit( $id = null ) {
		$id = (int) $id;

		if ( ! empty( $this->request->data ) ) {
			$id = (int) $this->request->data['ProjectExpense']['id'];
		}

		$data = $this->ProjectExpense->find( 'first', array(
			'conditions' => array(
				'ProjectExpense.id' => $id
			),
			'recursive' => -1
		) );

		if ( empty( $data ) ) {
			throw new NotFoundException();
		}

		$this->set( 'project_id', $data['ProjectExpense']['project_id'] );

		$this->set( 'edit', true );
		$this->set( 'title_for_layout', __( 'Edit a Project Update' ) );
		$this->initAddEditSubtitle();
		
		if ( $this->request->is( 'post' ) || $this->request->is( 'put' ) ) {

			$this->ProjectExpense->set( $this->request->data );

			if ( $this->ProjectExpense->validates() ) {
				if ( $this->ProjectExpense->save() ) {
					$this->Session->setFlash( __( 'Project Expense was successfully edited.' ), FLASH_OK );
					$this->redirect( array( 'controller' => 'projects', 'action' => 'index' ) );
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
		$this->set( 'subtitle_for_layout', __( 'Use this form to create or edit new improvement expense. In this way you can control financial expenses on your projects.' ) );
	}

}
?>