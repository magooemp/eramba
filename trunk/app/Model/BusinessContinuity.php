<?php
class BusinessContinuity extends AppModel {
	public $validate = array(
		'title' => array(
			'rule' => 'notEmpty',
			'required' => true,
			'allowEmpty' => false
		),
		'business_unit_id' => array(
			'rule' => array( 'multiple', array( 'min' => 1 ) )
		),
		'threat_id' => array(
			'rule' => array( 'multiple', array( 'min' => 1 ) )
		),
		'vulnerability_id' => array(
			'rule' => array( 'multiple', array( 'min' => 1 ) )
		),
		'risk_mitigation_strategy_id' => array(
			'rule' => 'notEmpty',
			'required' => true
		),
		'security_service_id' => array(
			'rule' => array( 'multiple', array( 'min' => 1 ) )
		),
		'residual_score' => array(
			'rule' => 'numeric',
			'required' => true
		),
		'risk_exception_id' => array(
			'rule' => array( 'multiple', array( 'min' => 1 ) )
		),
		'user_id' => array(
			'rule' => 'notEmpty',
			'required' => true
		),
		'review' => array(
			'rule' => 'date',
			'required' => true
		)
	);

	public $belongsTo = array(
		'RiskMitigationStrategy' => array(),
		'User' => array()
	);

	public $hasAndBelongsToMany = array(
		'BusinessUnit' => array(),
		'Threat' => array(),
		'Vulnerability' => array(),
		'SecurityService' => array(),
		'RiskException' => array(),
		'RiskClassification' => array()
	);
}
?>