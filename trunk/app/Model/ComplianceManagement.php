<?php
class ComplianceManagement extends AppModel {
	public $validate = array(
		'efficacy' => array(
			'rule' => 'notEmpty',
			'required' => true
		)
	);

	public $hasAndBelongsToMany = array(
		'SecurityService' => array(),
		'SecurityPolicy' => array()
	);

	public $belongsTo = array(
		'ComplianceTreatmentStrategy' => array(),
		'ComplianceException' => array()
	);
}
?>