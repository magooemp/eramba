<?php
class SecurityIncident extends AppModel {
	public $validate = array(
		'title' => array(
			'rule' => 'notEmpty',
			'required' => true
		),
		'security_service_id' => array(
			'rule' => array( 'multiple', array( 'min' => 1 ) )
		)
	);

	public $belongsTo = array(
		'SecurityIncidentStatus' => array(),
		'ThirdParty' => array(),
		'SecurityIncidentClassification' => array(),
		'Asset' => array()
	);

	public $hasAndBelongsToMany = array(
		'SecurityService' => array()
	);
}
?>