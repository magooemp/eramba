<?php
class ThirdParty extends AppModel {
	public $validate = array(
		'name' => array(
			'rule' => 'notEmpty',
			'required' => true
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