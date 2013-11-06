<?php
class CompliancePackage extends AppModel {
	public $validate = array(
		'name' => array(
			'rule' => 'notEmpty',
			'required' => true,
			'allowEmpty' => false
		),
		'package_id' => array(
			'rule' => 'notEmpty',
			'required' => true,
			'allowEmpty' => false
		)
	);

	public $belongsTo = array(
		'ThirdParty' => array()
	);

	public $hasMany = array(
		'CompliancePackageItem' => array()
	);
}
?>