<?php
class ThirdParty extends AppModel {
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
		'ServiceContract' => array()
	);
}
?>