<?php
class GroupsController extends AppController {
	public $name = 'Groups';
	public $uses = array('Group');
	public $components = array();

	public function beforeFilter() {
		parent::beforeFilter();
	}

	public function index() {
		$this->set( 'title_for_layout', __('Role Management') );
		$this->set( 'subtitle_for_layout', __( 'This is the current list of roles defined on the system.' ) );
		
		$this->paginate = array(
			'conditions' => array(
				
			),
			'fields' => array(
				'Group.id', 'Group.name'
			),
			'order' => array('Group.id' => 'ASC'),
			'limit' => $this->getPageLimit(),
			'recursive' => -1
		);

		$data = $this->paginate('Group');

		$this->set('data', $data);
	}

	public function add() {
		$this->set( 'title_for_layout', __('Create a Role') );
		$this->set( 'subtitle_for_layout', __( 'You can control user access to eramba by defining roles and later assigning them to user accounts. For each role, you must define to which sections of the system groups are allowed to access and edit information.' ) );
		
		if (!empty($this->request->data)) {
			unset($this->request->data['Group']['id']);
			
			$this->Group->set($this->request->data);

			if ($this->Group->validates()) {
				if ($this->Group->save()) {
					$this->Session->setFlash(__('Role was successfully added.'), FLASH_OK);
					$this->redirect(array('controller' => 'groups', 'action' => 'index'));
				}
				else {
					$this->Session->setFlash(__('Error while saving the data. Please try it again.'), FLASH_ERROR);
				}
			}
		}
	}

	public function edit($id = null) {
		$id = (int) $id;
		$this->set('edit', true);
		$this->set( 'title_for_layout', __('Edit Role') );
		$this->set( 'subtitle_for_layout', __( 'You can control user access to eramba by defining roles and later assigning them to user accounts. For each role, you must define to which sections of the system groups are allowed to access and edit information.' ) );

		if (!empty($this->request->data)) {
			$id = (int) $this->request->data['Group']['id'];
		}

		$group = $this->Group->find('first', array(
			'conditions' => array(
				'Group.id' => $id,
			),
			'recursive' => -1
		));
		
		if (empty($group)) {
			throw new NotFoundException();
		}

		if (!empty($this->request->data)) {
			$this->Group->set($this->request->data);

			if ($this->Group->validates()) {
				if ($this->Group->save()) {
					$this->Session->setFlash(__('Role was successfully edited.'), FLASH_OK);
					$this->redirect(array('controller' => 'groups', 'action' => 'index'));
				}
				else {
					$this->Session->setFlash(__('Error while saving the data. Please try it again.'), FLASH_ERROR);
				}
			}
		}
		else {
			$this->request->data = $group;
		}

		$this->render('add');
	}

	public function delete($id = null) {
		$id = (int) $id;

		$group = $this->Group->find('first', array(
			'conditions' => array(
				'Group.id' => $id,
			),
			'recursive' => -1
		));

		if (empty($group)) {
			throw new NotFoundException();
		}

		if ($this->Group->delete($id)) {
			$this->Session->setFlash(__('Role was successfully deleted.'), FLASH_OK);
		}
		else {
			$this->Session->setFlash(__('Error while deleting the data. Please try it again.'), FLASH_ERROR);
		}
		
		$this->redirect(array('controller' => 'groups', 'action' => 'index'));
	}
}