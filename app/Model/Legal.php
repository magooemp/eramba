<?php
class Legal extends AppModel {
	public $validate = array(
		'name' => array(
			'rule' => 'notEmpty',
			'required' => true,
			'allowEmpty' => false
		),
		'description' => array(
		),
		'risk_magnifier' => array(
			'rule' => 'numeric',
			'allowEmpty' => true
		)
	);
}
?>