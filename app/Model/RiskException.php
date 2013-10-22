<?php
class RiskException extends AppModel {
	public $validate = array(
		'title' => array(
			'rule' => 'notEmpty',
			'required' => true
		),
		'expiration' => array(
			'rule' => 'notEmpty',
			'required' => true
		)
	);
}
?>