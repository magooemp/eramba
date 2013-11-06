<?php
class ComplianceAudit extends AppModel {
	public $validate = array(
		'name' => array(
			'rule' => 'notEmpty',
			'required' => true,
			'allowEmpty' => false
		),
		'compliance_package_id' => array(
			'rule' => 'notEmpty',
			'required' => true
		),
		'date' => array(
			'rule' => 'date',
			'required' => true
		)
	);

	public $belongsTo = array(
		'ThirdParty' => array()
	);

	public $hasMany = array(
		'ComplianceFinding' => array()
	);
}
?>