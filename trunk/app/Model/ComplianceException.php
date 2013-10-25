<?php
class ComplianceException extends AppModel {
	public $validate = array(
		'title' => array(
			'rule' => 'notEmpty',
			'required' => true
		)
	);
}
?>