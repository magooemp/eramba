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
		'rpo' => array(
			'rule' => 'numeric',
			'required' => true,
			'allowEmpty' => false
		)
	);

	public $hasMany = array(
		'Process' => array()
	);

	public $hasAndBelongsToMany = array(
		'Asset' => array()
	);
}
?>