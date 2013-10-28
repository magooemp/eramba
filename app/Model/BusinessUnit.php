<?php
class BusinessUnit extends AppModel {
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
		),
		'rpo' => array(
			'rule' => 'numeric',
			'required' => true,
			'allowEmpty' => false
		)
	);

	public $hasMany = array(
		'Process' => array()
	);
}
?>