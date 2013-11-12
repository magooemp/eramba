<?php
class Project extends AppModel {
	public $actsAs = array(
		'Containable'
	);

	public $validate = array(
		'title' => array(
			'rule' => 'notEmpty',
			'required' => true,
			'allowEmpty' => false
		),
		'start' => array(
			'rule' => 'date'
		),
		'deadline' => array(
			'rule' => 'date'
		),
		'plan_budget' => array(
			'rule' => 'numeric'
		)
	);

	public $belongsTo = array(
		'ProjectStatus' => array(),
		'User' => array()
	);

	public $hasMany = array(
		'ProjectAchievement' => array(),
		'ProjectExpense' => array()
	);
}
?>