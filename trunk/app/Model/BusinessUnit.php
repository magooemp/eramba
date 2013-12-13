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
		'revenue' => array(
			'rule' => 'notEmpty',
			'required' => true
		)
	);

	public $hasMany = array(
		'Process' => array()
	);

	public $hasAndBelongsToMany = array(
		'Asset' => array(),
		'BusinessContinuity' => array()
	);
}
?>