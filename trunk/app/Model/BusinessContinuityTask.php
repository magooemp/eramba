<?php
class BusinessContinuityTask extends AppModel {
	public $validate = array(
		'step' => array(
			'rule' => 'notEmpty',
			'required' => true,
			'allowEmpty' => false
		),
		'when' => array(
			'rule' => 'notEmpty',
			'allowEmpty' => false,
			'required' => true
		),
		'who' => array(
			'rule' => 'notEmpty',
			'required' => true,
			'allowEmpty' => false
		),
		'does' => array(
			'rule' => 'notEmpty',
			'required' => true,
			'allowEmpty' => false
		),
		'where' => array(
			'rule' => 'notEmpty',
			'required' => true,
			'allowEmpty' => false
		),
		'how' => array(
			'rule' => 'notEmpty',
			'required' => true,
			'allowEmpty' => false
		)
	);

	public $belongsTo = array(
		'BusinessContinuityPlan' => array()
	);
}
?>