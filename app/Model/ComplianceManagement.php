<?php
class ComplianceManagement extends AppModel {
	public $validate = array(
		/*'name' => array(
			'rule' => 'notEmpty',
			'required' => true,
			'allowEmpty' => false
		)*/
	);

	public $hasAndBelongsToMany = array(
		'SecurityService' => array(),
		'SecurityPolicy' => array()
	);

	public $belongsTo = array(
		'ComplianceTreatmentStrategy' => array(),
		'ComplianceException' => array(),
		'ComplianceStatus' => array()
	);
}
?>