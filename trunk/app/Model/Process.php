<?php
class Process extends AppModel {
	public $validate = array(
		'name' => array(
			'rule' => 'notEmpty',
			'required' => true
		)
	);

	public $belongsTo = array(
		'BusinessUnit' => array()
	);
}
?>