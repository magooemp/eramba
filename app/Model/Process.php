<?php
class Process extends AppModel {
	public $validate = array(
		'name' => array(
			'rule' => 'notEmpty',
			'required' => true,
			'allowEmpty' => false
		),
		'description' => array(
		),
		'rto' => array(
			'rule' => 'numeric',
			'required' => true,
			'allowEmpty' => false
		),
	);

	public $belongsTo = array(
		'BusinessUnit' => array()
	);
}
?>