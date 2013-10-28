<?php
class ServiceContract extends AppModel {
	public $validate = array(
		'name' => array(
			'rule' => 'notEmpty',
			'required' => true,
			'allowEmpty' => false
		),
		'value' => array(
			'rule' => 'numeric',
			'required' => true
		),
		'start' => array(
			'rule' => 'date',
			'required' => true
		),
		'end' => array(
			'rule' => 'date',
			'required' => true
		)
	);

	public $belongsTo = array(
		'ThirdParty' => array()
	);
}
?>