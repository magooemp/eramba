<?php
class ProjectAchievementsController extends AppController {
	public $helpers = array( 'Html', 'Form' );
	public $components = array( 'Session' );

	public function index( $project_id = null ) {
		$project_id = (int) $project_id;

		$this->set( 'title_for_layout', __( 'List of Project Updates' ) );
		$this->set( 'subtitle_for_layout', __( 'This is the list of project updates.' ) );

		$this->paginate = array(
			'conditions' => array(
				'ProjectAchievement.project_id' => $project_id
			),
			'fields' => array(
				'ProjectAchievement.id',
				'ProjectAchievement.description',
				'ProjectAchievement.date',
				'ProjectAchievement.completion',
				'User.id',
				'User.name',
				'User.surname',
				'Project.id',
				'Project.title'
			),
			'order' => array('ProjectAchievement.id' => 'ASC'),
			'limit' => $this->getPageLimit(),
			'recursive' => 0
		);

		$data = $this->paginate( 'ProjectAchievement' );
		$this->set( 'data', $data );
		$this->set( 'project_id', $project_id );

	}

	/*public function delete( $id = null ) {
		$data = $this->Legal->find( 'count', array(
			'conditions' => array(
				'Legal.id' => $id
			)
		) );

		if ( empty( $data ) ) {
			throw new NotFoundException();
		}

		if ( $this->Legal->delete( $id ) ) {
			$this->Session->setFlash( __( 'Legal Constrain was successfully deleted.' ), FLASH_OK );
		} else {
			$this->Session->setFlash( __( 'Error while deleting the data. Please try it again.' ), FLASH_ERROR );
		}

		$this->redirect( array( 'controller' => 'legals', 'action' => 'index' ) );
	}*/

	public function add( $project_id = null ) {
		$project_id = (int) $project_id;

		$this->set( 'title_for_layout', __( 'Create a Project Update' ) );
		$this->initAddEditSubtitle();
		
		if ( $this->request->is( 'post' ) ) {
			unset( $this->request->data['ProjectAchievement']['id'] );

			$this->ProjectAchievement->set( $this->request->data );

			if ( $this->ProjectAchievement->validates() ) {
				if ( $this->ProjectAchievement->save() ) {
					$this->Session->setFlash( __( 'Project Update was successfully added.' ), FLASH_OK );
					$this->redirect( array( 'controller' => 'projects', 'action' => 'index' ) );
				} else {
					$this->Session->setFlash( __( 'Error while saving the data. Please try it again.' ), FLASH_ERROR );
				}
			} else {
				$this->Session->setFlash( __( 'One or more inputs you entered are invalid. Please try again.' ), FLASH_ERROR );
			}
		}

		$this->set( 'project_id', $project_id );

		$this->initOptions();
	}

	public function edit( $id = null ) {
		$id = (int) $id;

		if ( ! empty( $this->request->data ) ) {
			$id = (int) $this->request->data['ProjectAchievement']['id'];
		}

		$data = $this->ProjectAchievement->find( 'first', array(
			'conditions' => array(
				'ProjectAchievement.id' => $id
			),
			'recursive' => -1
		) );

		if ( empty( $data ) ) {
			throw new NotFoundException();
		}

		$this->set( 'project_id', $data['ProjectAchievement']['project_id'] );

		$this->set( 'edit', true );
		$this->set( 'title_for_layout', __( 'Edit a Project Update' ) );
		$this->initAddEditSubtitle();
		
		if ( $this->request->is( 'post' ) || $this->request->is( 'put' ) ) {

			$this->ProjectAchievement->set( $this->request->data );

			if ( $this->ProjectAchievement->validates() ) {
				if ( $this->ProjectAchievement->save() ) {
					$this->Session->setFlash( __( 'Project Update was successfully edited.' ), FLASH_OK );
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

		$this->initOptions();

		$this->render( 'add' );
	}

	/**
	 * Initialize options for join elements.
	 */
	private function initOptions() {
		$this->set( 'user_id', $this->logged['id'] );
		$this->set( 'user_name', $this->logged['name'] . ' ' . $this->logged['surname'] );
	}

	private function initAddEditSubtitle() {
		$this->set( 'subtitle_for_layout', __( 'Use this form to update news on the project.' ) );
	}

}
?>