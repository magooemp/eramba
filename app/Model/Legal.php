<?php
class Legal extends AppModel {
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