<?php
class BusinessUnit extends AppModel {
	public $name = 'BusinessUnit';
	public $actsAs = array(
		'Containable'
	);

	public $validate = array(
		'name' => array(
			'rule' => 'notEmpty',
			'required' => true
		),
		'description' => array(
		)
	);

	public $hasMany = array(
		'Process' => array()
	);
}
?>