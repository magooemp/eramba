<?php
App::uses('Component', 'Controller');
class MenuComponent extends Component {
	public $components = array('Acl');

	public function startup(Controller $controller) {
		$this->controller = $controller;
	}
	
	public function initialize(Controller $controller) {
		$this->controller = $controller;
	}
	
	/**
	 * Define here all possible actions for the menu
	 * 
	 * WHEN YOU ADD NEW ITEMS, PLEASE DELETE ALL ACL CACHE FILES FOR MENU
	 */
	private function getActions() {
		return array(
			array(
				'name' => __('Organization'),
				'children' => array(
					array(
						'name' => __('Business Units'),
						'url' => array(
							'controller' => 'businessUnits', 'action' => 'index', 'admin' => false, 'plugin' => null
						)
					),
					array(
						'name' => __('Legal Constrains'),
						'url' => array(
							'controller' => 'legals', 'action' => 'index', 'admin' => false, 'plugin' => null
						)
					),
					array(
						'name' => __('Third Parties'),
						'url' => array(
							'controller' => 'thirdParties', 'action' => 'index', 'admin' => false, 'plugin' => null
						)
					)
				)
			),
			array(
				'name' => __('Asset Management'),
				'children' => array(
					array(
						'name' => __('Asset Classification'),
						'url' => array(
							'controller' => 'assetClassifications', 'action' => 'index', 'admin' => false, 'plugin' => null
						)
					),
					array(
						'name' => __('Asset Identification'),
						'url' => array(
							'controller' => 'assets', 'action' => 'index', 'admin' => false, 'plugin' => null
						)
					),
					array(
						'name' => __('Data Asset Analysis'),
						'url' => array(
							'controller' => 'dataAssets', 'action' => 'index', 'admin' => false, 'plugin' => null
						)
					),
					array(
						'name' => __('Asset Labeling'),
						'url' => array(
							'controller' => 'assetLabels', 'action' => 'index', 'admin' => false, 'plugin' => null
						)
					),
				)
			),
			array(
				'name' => __('Controls Catalogue'),
				'children' => array(
					array(
						'name' => __('Security Services'),
						'url' => array(
							'controller' => 'securityServices', 'action' => 'index', 'admin' => false, 'plugin' => null
						)
					),
					array(
						'name' => __('Services Contracts'),
						'url' => array(
							'controller' => 'serviceContracts', 'action' => 'index', 'admin' => false, 'plugin' => null
						)
					),
					array(
						'name' => __('Services Classification'),
						'url' => array(
							'controller' => 'serviceClassifications', 'action' => 'index', 'admin' => false, 'plugin' => null
						)
					),
					array(
						'name' => __('Business Continuity Plans'),
						'url' => array(
							'controller' => 'businessContinuityPlans', 'action' => 'index', 'admin' => false, 'plugin' => null
						)
					),
					array(
						'name' => __('Security Policies'),
						'url' => array(
							'controller' => 'securityPolicies', 'action' => 'index', 'admin' => false, 'plugin' => null
						)
					)
				)
			),
			array(
				'name' => __('Risk Management'),
				'children' => array(
					array(
						'name' => __('Risk Classifications'),
						'url' => array(
							'controller' => 'riskClassifications', 'action' => 'index', 'admin' => false, 'plugin' => null
						)
					),
					array(
						'name' => __('Asset Risk Management'),
						'url' => array(
							'controller' => 'risks', 'action' => 'index', 'admin' => false, 'plugin' => null
						)
					),
					array(
						'name' => __('Risk Exceptions'),
						'url' => array(
							'controller' => 'riskExceptions', 'action' => 'index', 'admin' => false, 'plugin' => null
						)
					),
					array(
						'name' => __('Third Party Risk Management'),
						'url' => array(
							'controller' => 'thirdPartyRisks', 'action' => 'index', 'admin' => false, 'plugin' => null
						)
					),
					array(
						'name' => __('Business Continuity'),
						'url' => array(
							'controller' => 'businessContinuities', 'action' => 'index', 'admin' => false, 'plugin' => null
						)
					)
				)
			),
			array(
				'name' => __('Compliance Management'),
				'children' => array(
					array(
						'name' => __('Compliance Exception'),
						'url' => array(
							'controller' => 'complianceExceptions', 'action' => 'index', 'admin' => false, 'plugin' => null
						)
					),
					array(
						'name' => __('Compliance Packages'),
						'url' => array(
							'controller' => 'compliancePackages', 'action' => 'index', 'admin' => false, 'plugin' => null
						)
					),
					array(
						'name' => __('Compliance Analysis'),
						'url' => array(
							'controller' => 'complianceManagements', 'action' => 'index', 'admin' => false, 'plugin' => null
						)
					),
					array(
						'name' => __('Audit Management'),
						'url' => array(
							'controller' => 'complianceAudits', 'action' => 'index', 'admin' => false, 'plugin' => null
						)
					)
				)
			),
			array(
				'name' => __('Security Operations'),
				'children' => array(
					array(
						'name' => __('Project Management'),
						'url' => array(
							'controller' => 'projects', 'action' => 'index', 'admin' => false, 'plugin' => null
						)
					),
					array(
						'name' => __('Security Incidents'),
						'url' => array(
							'controller' => 'securityIncidents', 'action' => 'index', 'admin' => false, 'plugin' => null
						)
					),
					array(
						'name' => __('Security Incident Classification'),
						'url' => array(
							'controller' => 'securityIncidentClassifications', 'action' => 'index', 'admin' => false, 'plugin' => null
						)
					),
					array(
						'name' => __('Policy Exceptions'),
						'url' => array(
							'controller' => 'policyExceptions', 'action' => 'index', 'admin' => false, 'plugin' => null
						)
					)
				)
			),
			array(
				'name' => __('System Management'),
				'children' => array(
					array(
						'name' => __('User Accounts'),
						'url' => array(
							'controller' => 'users', 'action' => 'index', 'admin' => false, 'plugin' => null
						)
					),
					array(
						'name' => __('Role Management'),
						'url' => array(
							'controller' => 'aros', 'action' => 'ajax_role_permissions', 'admin' => true, 'plugin' => 'acl'
						)
					)
				)
			)
		);
	}
	
	/**
	 * Return menu based on user rights
	 * 
	 * @param integer $groupId users group id
	 */
	public function getMenu($groupId) {
		
		if (($userActions = Cache::read('menu_items_'. $groupId, 'acl')) === false) {
			
			$userActions = $this->checkMenuItems($groupId);
			
			Cache::write('menu_items_'. $groupId, $userActions, 'acl');
		}
		
		return $userActions;
	}
	
	/**
	 * Check the menu based on unser rights in acl
	 * 
	 * @param integer $groupId users group id
	 */
	private function checkMenuItems($groupId) {
		$actions = $this->getActions();
		$userActions = array();
		
		foreach ($actions as $section) {
			$localActions = array();
				
			//check rights for each children
			foreach ($section['children'] as $action) {
				$actionPrefix = '';
				$adminPrefixes = Configure::read('Routing.prefixes');
		
				//check if the url contains admin prefixes - if so include it to action as prefix
				if (is_array($adminPrefixes)) {
					foreach ($adminPrefixes as $prefix) {
						if (isset($action['url'][$prefix]) && $action['url'][$prefix]) {
							$actionPrefix = $prefix . '_';
							break;
						}
					}
				}
				elseif (!empty($adminPrefixes)) {
					if (isset($action['url'][$adminPrefixes]) && $action['url'][$adminPrefixes]) {
						$actionPrefix = $adminPrefixes . '_';
						break;
					}
				}
		
				//check the rights
				$hasRights = $this->Acl->check(array('Group' => array('id' => $groupId)), ucfirst($action['url']['controller']) .'/'. $actionPrefix . $action['url']['action']);
		
				//if user has the right for the action include it
				if ($hasRights) {
					$localActions[] = $action;
				}
			}
				
			if (!empty($localActions)) {
				unset($section['children']);
		
				$localSection = $section;
				$localSection['children'] = $localActions;
		
				$userActions[] = $localSection;
			}
		}
		
		return $userActions;
	}
}