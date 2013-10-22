<?php
class BusinessContinuityPlan extends AppModel {
	public $validate = array(
		'title' => array(
			'rule' => 'notEmpty',
			'required' => true
		),
		'objective' => array(
			'rule' => 'notEmpty',
			'required' => true
		),
		'audit_metric' => array(
			'rule' => 'notEmpty',
			'required' => true
		),
		'audit_success_criteria' => array(
			'rule' => 'notEmpty',
			'required' => true
		),
		'security_service_type_id' => array(
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
		),
		'regular_review' => array(
			'rule' => 'notEmpty',
			'required' => true
		)
	);

	public $belongsTo = array(
		'SecurityServiceType' => array()
	);

	public $hasMany = array(
		'BusinessContinuityTask' => array()
	);
}
?>