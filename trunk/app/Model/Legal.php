<?php
class Legal extends AppModel {
	public $name = 'Legal';

	public $validate = array(
		'name' => array(
			'rule' => 'notEmpty',
			'required' => true
		),
		'description' => array(
			//'rule' => 'notEmpty'
		),
		'risk_magnifier' => array(
			'rule' => 'notEmpty'
		)
	);
}
?>