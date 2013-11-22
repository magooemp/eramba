<?php
class BusinessContinuityPlan extends AppModel {
	public $actsAs = array(
		'Containable'
	);

	public $validate = array(
		'title' => array(
			'rule' => 'notEmpty',
			'required' => true,
			'allowEmpty' => false
		),
		'objective' => array(
			'rule' => 'notEmpty',
			'required' => true,
			'allowEmpty' => false
		),
		'audit_metric' => array(
			'rule' => 'notEmpty',
			'required' => true,
			'allowEmpty' => false
		),
		'audit_success_criteria' => array(
			'rule' => 'notEmpty',
			'required' => true,
			'allowEmpty' => false
		),
		'security_service_type_id' => array(
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
		),
		'regular_review' => array(
			'rule' => 'date',
			'required' => true
		)
	);

	public $belongsTo = array(
		'SecurityServiceType' => array()
	);

	public $hasMany = array(
		'BusinessContinuityTask' => array(),
		'BusinessContinuityPlanAudit' => array(),
		'BusinessContinuityPlanAuditDate' => array()
	);
}
?>