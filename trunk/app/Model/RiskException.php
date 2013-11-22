<?php
class RiskException extends AppModel {
	public $validate = array(
		'title' => array(
			'rule' => 'notEmpty',
			'required' => true,
			'allowEmpty' => false
		),
		'expiration' => array(
			'rule' => 'date',
			'required' => true
		)
	);

	public $hasAndBelongsToMany = array(
		'SecurityPolicy' => array()
	);
}
?>