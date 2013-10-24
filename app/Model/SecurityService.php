<?php
class SecurityService extends AppModel {
	public $validate = array(
		'name' => array(
			'rule' => 'notEmpty',
			'required' => true
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
			'rule' => 'notEmpty',
			'required' => true
		),
		'capex' => array(
			'rule' => 'notEmpty',
			'required' => true
		),
		'resource_utilization' => array(
			'rule' => 'notEmpty',
			'required' => true
		)
	);

	public $belongsTo = array(
		'SecurityServiceType' => array(),
		'ServiceClassification' => array()
	);

	public $hasAndBelongsToMany = array(
		'ServiceContract' => array(
			//'joinTable' => 'security_services_service_contracts'
		)
	);
}
?>