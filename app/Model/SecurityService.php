<?php
class SecurityService extends AppModel {
	public $actsAs = array(
		'Containable'
	);

	public $validate = array(
		'name' => array(
			'rule' => 'notEmpty',
			'required' => true,
			'allowEmpty' => false
		),
		'audit_metric_description' => array(
			'rule' => 'notEmpty',
			'required' => true
		),
		'audit_success_criteria' => array(
			'rule' => 'notEmpty',
			'required' => true
		),
		'maintenance_metric_description' => array(
			'rule' => 'notEmpty',
			'required' => true
		),
		'opex' => array(
			'rule' => 'numeric',
			'required' => true
		),
		'capex' => array(
			'rule' => 'numeric',
			'required' => true
		),
		'resource_utilization' => array(
			'rule' => 'numeric',
			'required' => true
		)
	);

	public $belongsTo = array(
		'SecurityServiceType' => array(),
		'ServiceClassification' => array(),
		'User' => array()
	);

	public $hasMany = array(
		'SecurityServiceAudit' => array(),
		'SecurityServiceAuditDate' => array(),
		'SecurityServiceMaintenance' => array(),
		'SecurityServiceMaintenanceDate' => array(),
	);

	public $hasAndBelongsToMany = array(
		'ServiceContract' => array(),
		'SecurityPolicy' => array(),
		'Risk' => array(),
		'ThirdPartyRisk' => array(),
		'SecurityIncident' => array(),
		'DataAsset' => array(),
		'ComplianceManagement' => array()
	);
}
?>