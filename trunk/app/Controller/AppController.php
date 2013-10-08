<?php
App::uses('Controller', 'Controller');

class AppController extends Controller {
	public $uses = array();
	public $components = array(
		'Auth' => array(
			'loginAction' => array('controller' => 'users', 'action' => 'login'),
			'loginRedirect' => array('controller' => 'dashboard', 'action' => 'index'),
			'logoutRedirect' => array('controller' => 'users', 'action' => 'login'),
			'authenticate' => array(
				'Blowfish' => array(
					'fields' => array('username' => 'login'),
					'scope' => array('User.status' => USER_ACTIVE)
				)
			)
		),
		'RequestHandler', 'Cookie', 'Session', 'DebugKit.Toolbar'
	);
	public $helpers = array('Html', 'Form');
	protected $logged = null;
	protected $geoLocation = null;
	
	public function beforeFilter() {
		$this->setDefaultCookies();
	
		//handling the default language
		//$this->initlanguage();
	
		//debug for ajax
		if (isset($this->request->params['named']['ajax'])) {
			$this->layout = null;
			Configure::write('debug', Configure::read('ajaxDebug'));
		}
	
		$this->Auth->allow('changeLanguage');
	
		//using blowfish algoritm
		Security::setHash('blowfish');
		
		//check login session
		$this->logged = $this->Auth->user();
		$this->set('logged', $this->logged);
		
		if (!empty($this->logged)) {
			
		}
	}
	
	public function isAuthorized() {
		return true;
	}
	
	/**
	 * Default settings for cookies
	 *
	 * @author martin.malych
	 */
	private function setDefaultCookies() {
		$this->Cookie->name   = 'ErambaCookie';
		$this->Cookie->time   = '+2 weeks';
		$this->Cookie->domain = LINK_DOMAIN;
		$this->Cookie->key	= 'k886fQz1O787u4r4q07DGvLkjTMP4VZ2pU1wA934Sxsm934mRa';
	
		if (HTTP_PROTOCOL == 'https://') {
			$this->Cookie->secure = true;
		}
		else {
			$this->Cookie->secure = false;
		}
	
		$this->Cookie->type('rijndael');
	}
	
	/**
	 * Init email function. You have to call $email->send() to send email after init.
	 *
	 * @param mixed $to 1 or more email addresses
	 * @param string $subject email subject
	 * @param string $template template name
	 * @param array $data date for template
	 * @param string $layout layout which will be used
	 * @param mixed $from from email address
	 * @param string $type text|html|both
	 * @return return email object
	 * @author martin.malych
	 */
	protected function initEmail($to, $subject, $template, $data = array(), $layout = 'default', $from = NO_REPLY_EMAIL, $type = 'html') {
			
		App::uses('CakeEmail', 'Network/Email');
		
		$email = new CakeEmail('default');
		
		//v pripade ze mame zapnute smtp
		if (SMTP_USE == 1) {
			$email->config(array(
				'transport' => 'Smtp',
				'host' => SMTP_HOST,
				'username' => SMTP_USER,
				'password' => SMTP_PWD,
				'timeout' => SMTP_TIMEOUT,
				'port' => SMTP_PORT,
				'charset' => 'utf-8',
				'headerCharset' => 'utf-8'
			));
		}
	
		$email->from(array($from => NAME_SERVICE));
		$email->to($to);
		$email->subject($subject);
		$email->emailFormat($type);
		$email->template($template, $layout);
	
		if (!empty($data)) {
			$email->viewVars($data);
		}
	
		return $email;
	}
	
	/**
	 * Returns all available languages
	 *
	 * @author martin.malych
	 */
	protected function getAllSetLangs() {
		return availableLocals();
	}
	
	/**
	 * Initial language settings
	 *
	 * @author martin.malych
	 */
	protected function initlanguage() {
	   $this->setlanguage($this->getlanguage());
	}

	/**
	  * Return current language
	  */
	protected function getlanguage() {
		if (I18N_SET) {
			if (isset($this->params['language'])) {
				$lang = $this->params['language'];
			}
			else {
				//check the cookie
				$lang = $this->Cookie->read('vdl');
				
				if (empty($lang) || $lang == null) {
					$lang = DEFAULT_LOCALE_HTML;
				}
			}
		}
		else {
			$lang = DEFAULT_LOCALE_HTML;
		}

		return $lang;
	}
	
	/**
	 * Set the language
	 * 
	 * @param string $lang language which will be set
	 * @param boolean $changeLang if true, change is write to the cookie
	 * @author martin.malych
	 */
	private function setlanguage($lang = null, $changeLang = false) {
		if (I18N_SET) {
			//check if the language is available, if not set default lang
			if (!in_array($lang, array_keys($this->getAllSetLangs()))) {
				$lang = DEFAULT_LOCALE_HTML;
			}
		}
		//set default lang of i18n is off
		else {
			$lang = DEFAULT_LOCALE_HTML;
		}
		
		$savedLang = $this->Cookie->read('vdl');
		if ($changeLang || empty($savedLang)) {
			//write lang to cookie
			$this->Cookie->write('vdl', $lang, true, '+2 weeks');
		}
		//if the request is from the ling with lang
		elseif (isset($this->params['language'])) {
			//write lang to cookie
			$this->Cookie->write('vdl', $lang, true, '+2 weeks');
		}

		//set the lang for cake
		$cakeLocale = getCakeLocale($lang);
		if (empty($cakeLocale)) {
			$cakeLocale = DEFAULT_LOCALE;
		}
		Configure::write('Config.language', $cakeLocale);
		
		//set current language for views and controllers
		$this->language = $lang;
		$this->set('currentLocale', $this->language);
	}
	
	/**
	 * Changes the current language - public function
	 */
	public function changeLanguage() {
		if (!empty($this->request->params['locale'])) {
			$lang = $this->request->params['locale'];
		}
		else {
			$this->redirect($this->referer('/', true));
		}
		
		$this->setlanguage($lang, true);
		
		$this->redirect($this->referer('/', true));
	}
	
	/**
	 * Filter data from get sanitizing
	 *
	 * @author martin.malych
	 */
	protected function initFilter() {
		unset($this->request->query['ext']);
		unset($this->request->query['x']);
		unset($this->request->query['y']);
	
		if (!empty($this->request->query)) {
			$this->request->data['Filter'] = $this->request->query;
		}
		elseif (!empty($this->passedArgs)) {
			$this->request->data['Filter'] = $this->passedArgs;
		}
	}
	
	/**
	 * Returns current page limit
	 * 
	 * @return integer limit per page per user
	 * @author martin.malych
	 */
	protected function getPageLimit() {
		//if the limit was changed
		if (isset($this->request->params['named']['limit']) && is_numeric($this->request->params['named']['limit'])) {
			$limit = $this->request->params['named']['limit'];
			Cache::write('page_limit_' . $this->logged['id'], $limit, 'infinite');
		}
		//if the cache is invalid
		elseif (($limit = Cache::read('page_limit_' . $this->logged['id'], 'infinite')) === false) {
			$limit = DEFAULT_PAGE_LIMIT;
		}
		
		$this->set('currPageLimit', $limit);
		
		return $limit;
	}
	
}