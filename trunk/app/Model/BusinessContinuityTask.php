<?php
class BusinessContinuityTask extends AppModel {
	public $validate = array(
		'step' => array(
			'rule' => 'notEmpty',
			'required' => true
		),
		'when' => array(
			'rule' => 'notEmpty',
			'required' => true
		),
		'who' => array(
			'rule' => 'notEmpty',
			'required' => true
		),
		'does' => array(
			'rule' => 'notEmpty',
			'required' => true
		),
		'where' => array(
			'rule' => 'notEmpty',
			'required' => true
		),
		'how' => array(
			'rule' => 'notEmpty',
			'required' => true
		)
	);

	public $belongsTo = array(
		'BusinessContinuityPlan' => array()
	);
}
?>