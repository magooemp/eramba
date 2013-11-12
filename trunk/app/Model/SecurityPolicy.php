<?php
class SecurityPolicy extends AppModel {
	public $validate = array(
		'index' => array(
			'rule' => 'notEmpty',
			'required' => true,
			'allowEmpty' => false
		),
		'description' => array(
			'rule' => 'notEmpty',
			'required' => true,
			'allowEmpty' => false
		),
		'status' => array(
			'rule' => 'notEmpty',
			'required' => true
		)
	);
}
?>