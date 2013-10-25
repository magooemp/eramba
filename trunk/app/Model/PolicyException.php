<?php
class PolicyException extends AppModel {
	public $validate = array(
		'title' => array(
			'rule' => 'notEmpty',
			'required' => true
		)
	);

	public $belongsTo = array(
		'PolicyExceptionStatus' => array()
	);
}
?>