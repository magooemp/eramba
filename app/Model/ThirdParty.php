<?php
class ThirdParty extends AppModel {
	public $actsAs = array(
		'Containable'
	);

	public $validate = array(
		'name' => array(
			'rule' => 'notEmpty',
			'required' => true,
			'allowEmpty' => false
		),
		'description' => array(
		)
	);

	public $belongsTo = array(
		'ThirdPartyType' => array()
	);

	public $hasMany = array(
		'ServiceContract' => array(),
		'CompliancePackage' => array(),
		'ComplianceAudit' => array()
	);

	public $hasAndBelongsToMany = array(
		'ThirdPartyRisk' => array()
	);
}
?>