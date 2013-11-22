<?php
class PolicyException extends AppModel {
	public $validate = array(
		'title' => array(
			'rule' => 'notEmpty',
			'required' => true,
			'allowEmpty' => false
		),
		'expiration' => array(
			'rule' => 'date'
		)
	);

	public $belongsTo = array(
		'PolicyExceptionStatus' => array(),
		'User' => array()
	);

	public $hasAndBelongsToMany = array(
		'SecurityPolicy' => array()
	);
}
?>