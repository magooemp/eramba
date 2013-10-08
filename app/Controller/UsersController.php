<?php
class UsersController extends AppController {
	public $name = 'Users';
	public $uses = array('User');
	public $components = array('Ticketmaster');

	public function beforeFilter() {
		$this->Auth->allow('resetpassword', 'useticket');
		
		parent::beforeFilter();
	}
			
	public function isAuthorized() {
		return true;
	}

	public function index() {
		$this->set( 'title_for_layout', __('User Authorization') );
		$this->set( 'subtitle_for_layout', __( 'Define which system user can access what. Remember! Only those users listed here can access the system!' ) );
		
		$this->paginate = array(
			'conditions' => array(
				
			),
			'fields' => array(
				'User.id', 'User.login', 'User.name', 'User.surname', 'Group.name'
			),
			'order' => array('User.id' => 'ASC'),
			'limit' => $this->getPageLimit(),
			'recursive' => 0
		);

		$data = $this->paginate('User');

		$this->set('data', $data);
	}

	public function add() {
		$this->set( 'title_for_layout', __('Create a User Authorization') );
		$this->set( 'subtitle_for_layout', __( 'Create system users and assign them the appropiate Group Roles' ) );
		$this->initData();
		
		if (!empty($this->request->data)) {
			$this->request->data['User']['password'] = Security::hash($this->request->data['User']['pass']);
			unset($this->request->data['User']['id']);
			
			$this->User->set($this->request->data);

			if ($this->User->validates()) {
				if ($this->User->save()) {
					$this->Session->setFlash(__('User was successfully added.'), FLASH_OK);
					$this->redirect(array('controller' => 'users', 'action' => 'index'));
				}
				else {
					$this->Session->setFlash(__('Error while saving the data. Please try it again.'), FLASH_ERROR);
				}
			}
		}
		$this->request->data['User']['pass'] = $this->request->data['User']['pass2'] = '';
	}

	public function edit($id = null) {
		$id = (int) $id;
		$this->initData();
		$this->set('edit', true);
		$this->set( 'title_for_layout', __('Edit User Authorization') );
		$this->set( 'subtitle_for_layout', __( 'Edit system users and assign them the appropiate Group Roles' ) );

		if (!empty($this->request->data)) {
			$id = (int) $this->request->data['User']['id'];
		}

		$user = $this->User->find('first', array(
			'conditions' => array(
				'User.id' => $id,
			),
			'recursive' => -1
		));
		
		if (empty($user)) {
			throw new NotFoundException();
		}

		if (!empty($this->request->data)) {
			//validate pass
			$this->validateUserPwd($user, false);

			//ak nemame ziadne chyby pri zmene hesla
			if (empty($this->User->validationErrors)) {
				$this->User->create();
				
				unset($this->request->data['User']['pass']);
				$this->User->set($this->request->data);

				if ($this->User->validates()) {
					if ($this->User->save()) {
						$this->Session->setFlash(__('User was successfully edited.'), FLASH_OK);
						$this->redirect(array('controller' => 'users', 'action' => 'index'));
					}
					else {
						$this->Session->setFlash(__('Error while saving the data. Please try it again.'), FLASH_ERROR);
					}
				}
			}
		}
		else {
			$this->request->data = $user;
		}
		$this->request->data['User']['old_pass'] = $this->request->data['User']['pass'] = $this->request->data['User']['pass2'] = '';

		$this->render('add');
	}
	
	/**
	 * Ovaliduje stare heslo, overi nove heslo, ak je vsetko spravne
	 * tak nastavi userovi nove heslo
	 * 
	 * @author martin.malych
	 */
	private function validateUserPwd($user, $checkOldPwd = true) {
		if ((!$checkOldPwd || $this->request->data['User']['old_pass'] != '') && $this->request->data['User']['pass'] != '' && $this->request->data['User']['pass2'] != '') {
			//stare heslo musi byt spravne
			if ($user['User']['password'] == Security::hash($this->request->data['User']['old_pass'], 'blowfish', $user['User']['password'])) {
				$this->User->set($this->request->data);
				//ovalidujeme nove hesla
				if ($this->User->validates(array('fieldList' => array('pass')))) {
					//nastavime nove heslo
					$this->request->data['User']['password'] = Security::hash($this->request->data['User']['pass']);
				}
			}
			else {
				$this->User->invalidate('old_pass', __('Old password is wrong.'));
			}
		} //end zmena hesla
		else {
			unset($this->User->validate['pass']);
		}
	}

	public function delete($id = null) {
		$id = (int) $id;

		$user = $this->User->find('first', array(
			'conditions' => array(
				'User.id' => $id,
				'User.id !=' => $this->logged['id'],
			),
			'recursive' => -1
		));

		if (empty($user)) {
			throw new NotFoundException();
		}

		if ($this->User->delete($id)) {
			$this->Session->setFlash(__('User was successfully deleted.'), FLASH_OK);
		}
		else {
			$this->Session->setFlash(__('Error while deleting the data. Please try it again.'), FLASH_ERROR);
		}
		
		$this->redirect(array('controller' => 'users', 'action' => 'index'));
	}

	public function profile() {
		$this->set('title_for_layout', __('My profile'));
		$this->set( 'subtitle_for_layout', __( 'Edit your profile' ) );
		$this->initData();
		$id = $this->logged['id'];
		
		$user = $this->User->find('first', array(
			'conditions' => array(
				'User.id' 	  => $id,
				'User.status' => USER_ACTIVE
			),
			'recursive' => -1
		));

		if (empty($user)) {
			throw new NotFoundException();
			return;
		}
		
		if (!empty($this->request->data)) {
			//kontrola pri zmene stareho hesla
			$this->validateUserPwd($user);

			//ak nemame ziadne chyby pri zmene hesla
			if (empty($this->User->validationErrors)) {
				$this->User->create();
				$this->User->id = $id;
				
				//email ani skupinu si nesmie zmenit
				$this->request->data['User']['group_id'] = $user['User']['group_id'];

				$this->User->set($this->request->data);

				if ($this->User->validates()) {
					if ($this->User->save(null, true, array('name', 'surname', 'password', 'email'))) {
						$this->Session->setFlash(__('Profile was successfully updated.'), FLASH_OK);
						$this->redirect(array('controller' => 'users', 'action' => 'profile'));
					}
					else {
						$this->Session->setFlash(__('Error while saving the data. Please try it again.'), FLASH_ERROR);
					}
				}
			}
			$this->request->data['User']['old_pass'] = $this->request->data['User']['pass'] = $this->request->data['User']['pass2'] = '';
		}
		else {
			$this->request->data = $user;
		}
	}

	/**
	  * Method send email with link for password change.
	  */
	public function resetpassword() {
		$this->set('title_for_layout', __('Did you forgot your password?'));
		
		if (!empty($this->request->data)) {
			//find user
			$user = $this->User->find('first', array (
				'conditions' => array(
					'User.email'  => $this->request->data['User']['email'],
					'User.status' => USER_ACTIVE
				),
				'fields' => array('User.email'),
				'recursive' => -1
			));

			if (empty($user)) {
				throw new NotFoundException();
			}
			$this->loadModel('Ticket');
			
			//create hash
			$ticketHash = $this->Ticketmaster->createHash();

			//data for email
			$emailData = array(
				'token' => $ticketHash,
				'emailTitle' => __('Reset your password')
			);
			$emailResult = false;

			//data for ticket
			$data = array();
			$data['Ticket']['hash'] = $ticketHash;
			$data['Ticket']['data'] = $user['User']['email'];
			$data['Ticket']['expires'] = $this->Ticketmaster->getExpirationDate();

			//save ticket
			if (($ticketResult = $this->Ticket->save($data))) {
				//send the email with ticket
				$email = $this->initEmail($user['User']['email'], __('Reset Your Password'), 'reset_password', $emailData);
				$emailResult = $email->send();
			}

			//ak sa vsetko podarilo ok vratime vysledok
			if ($ticketResult && $emailResult) {
				$this->Session->setFlash(__('We have sent to your email address the link to change your password. Please check your email.'), FLASH_OK);

				$this->request->data = null;
			}
			else {
				$this->Session->setFlash(__('Error while saving the data. Please try it again.'), FLASH_ERROR);
			}
		}
	}

	/**
	  * Overi ci existuje ticket so zadanym heslom a ci je validny a po odoslani formulara
	  * zmeni pre usera heslo.
	  *
	  * @param string $hash hash retazec identifikujuci ticket
	  */
	public function useticket($hash = null) {
		$this->set('title_for_layout', __('Password change'));
		$this->loadModel('Ticket');
			
		if ($this->request->is('post')) {
			$this->User->set($this->request->data);

			//ovalidujeme heslo
			if ($this->User->validates(array('fieldList' => array('pass')))) {
				//najdeme ticket pre dany hash
				$ticket = $this->Ticketmaster->checkTicket($this->request->data['User']['hash']);

				//ak sme nasli ticket
				if (!empty($ticket)) {
					//najdeme usera s danym emailom
					$user = $this->User->find('first', array(
						'conditions' => array(
							'User.email'  => $ticket['Ticket']['data'],
							'User.status' => USER_ACTIVE
						),
						'recursive' => -1
					));

					//ak taky user existuje
					if (!empty($user)) {
						//zahashujeme heslo
						$user['User']['password'] = Security::hash($this->request->data['User']['pass']);

						$this->User->create();
						$this->User->set($user);

					//ulozime uzivatela s novym heslom
						if ($this->User->save(null, false, array('password'))) {
							//oznavime ticket ako pouzity, aby sa uz nedal pouzit znovu
							$this->Ticketmaster->useTicket($this->request->data['User']['hash']);

							$this->Session->setFlash(__('Your password was successfully changed. Now you can login again.'), FLASH_OK);
							$this->redirect(array('controller' => 'users', 'action' => 'login'));
						}
						else {
							$this->Session->setFlash(__('Error happened while processing your request. Please try again.'), FLASH_ERROR);
						}
					}
					else {
						$this->Session->setFlash(__('Requested ticket is invalid. Please contact the support center.'), FLASH_ERROR);
						$this->redirect(array('controller' => 'users', 'action' => 'login'));
					}
				}
				else{
					$this->Session->setFlash(__('Requested ticekt is invalid. Please try the password recovery process again.'), FLASH_ERROR);
					$this->redirect(array('controller' => 'users', 'action' => 'login'));
				}
			}
			$this->request->data['User']['pass'] = $this->request->data['User']['pass2'] = '';
		}
		else {
		//skontrolujeme ci ticket existuje
			$ticket = $this->Ticketmaster->checkTicket($hash);

			if (!empty($ticket)) {
				//najdeme uzivatela s danym emailom
				$user = $this->User->find('first', array(
					'conditions' => array(
						'User.email'  => $ticket['Ticket']['data'],
						'User.status' => USER_ACTIVE
					),
					'fields' => array('User.email'),
					'recursive' => -1
				));

				if (!empty($user)) {
					$this->request->data['User']['hash'] = $hash;
				}
				else {
					$this->Session->setFlash(__('Requested ticekt is invalid. Please try the password recovery process again.'), FLASH_ERROR);
					$this->redirect(array('controller' => 'users', 'action' => 'login'));
				}
			}
			else {
				$this->Session->setFlash(__('Requested ticekt is invalid. Please try the password recovery process again.'), FLASH_ERROR);
				$this->redirect(array('controller' => 'users', 'action' => 'login'));
			}
		}
	}
	
	public function login() {
		$this->set('title_for_layout', __('Login'));
	
		if ($this->logged != null) {
			$this->redirect($this->Auth->loginRedirect);
		}
		
		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
				$userId = $this->Auth->user('id');
				
				return $this->redirect($this->Auth->redirect());
			} 
			else {
				$this->Session->setFlash(__('Email or password was incorrect.'), FLASH_ERROR);
			}
		}
	}

	public function logout() {
		//$this->PermanentLogger->cleanup();
		$this->redirect($this->Auth->logout());
	}
	
	private function initData() {
		
		$groups = $this->User->Group->find('list', array(
			'order' => array('Group.name' => 'ASC'),
			'recursive' => -1
		));
		
		$this->set('groups', $groups);
	}
}