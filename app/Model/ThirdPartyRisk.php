<?php
class ThirdPartyRisk extends AppModel {
	public $validate = array(
		'title' => array(
			'rule' => 'notEmpty',
			'required' => true
		),
		'third_party_id' => array(
			'rule' => array( 'multiple', array( 'min' => 1 ) )
		),
		'asset_id' => array(
			'rule' => array( 'multiple', array( 'min' => 1 ) )
		),
		'threat_id' => array(
			'rule' => array( 'multiple', array( 'min' => 1 ) )
		),
		'vulnerability_id' => array(
			'rule' => array( 'multiple', array( 'min' => 1 ) )
		),
		'risk_classification_id' => array(
			'rule' => 'notEmpty',
			'required' => true
		),
		'risk_mitigation_strategy_id' => array(
			'rule' => 'notEmpty',
			'required' => true
		),
		'security_service_id' => array(
			'rule' => array( 'multiple', array( 'min' => 1 ) )
		),
		'residual_score' => array(
			'rule' => 'notEmpty',
			'required' => true
		),
		'risk_exception_id' => array(
			'rule' => array( 'multiple', array( 'min' => 1 ) )
		),
		'owner' => array(
			'rule' => 'notEmpty',
			'required' => true
		),
		'review' => array(
			'rule' => 'notEmpty',
			'required' => true
		)
	);

	public $belongsTo = array(
		'RiskClassification' => array(),
		'RiskMitigationStrategy' => array()
	);

	public $hasAndBelongsToMany = array(
		'ThirdParty' => array(),
		'Asset' => array(),
		'Threat' => array(),
		'Vulnerability' => array(),
		'SecurityService' => array(),
		'RiskException' => array()
	);
}
?>