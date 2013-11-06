<?php
class CompliancePackageItem extends AppModel {
	public $validate = array(
		'name' => array(
			'rule' => 'notEmpty',
			'required' => true,
			'allowEmpty' => false
		),
		'item_id' => array(
			'rule' => 'notEmpty',
			'required' => true,
			'allowEmpty' => false
		)
	);

	public $belongsTo = array(
		'CompliancePackage' => array()
	);

	public $hasOne = array(
		'ComplianceManagement' => array()
	);
}
?>