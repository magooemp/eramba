<?php
class SecurityIncident extends AppModel {
	public $validate = array(
		'title' => array(
			'rule' => 'notEmpty',
			'required' => true,
			'allowEmpty' => false
		),
		'security_service_id' => array(
			'rule' => array( 'multiple', array( 'min' => 1 ) )
		),
		'open_date' => array(
			'rule' => 'date'
		),
		'closure_date' => array(
			'rule' => 'date'
		)
	);

	public $belongsTo = array(
		'SecurityIncidentStatus' => array(),
		'ThirdParty' => array(),
		'SecurityIncidentClassification' => array(),
		'Asset' => array(),
		'User' => array()
	);

	public $hasAndBelongsToMany = array(
		'SecurityService' => array()
	);
}
?>