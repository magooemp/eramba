<?php
class Project extends AppModel {
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
		),
		'current_budget' => array(
			'rule' => 'numeric'
		),
		'completion' => array(
			'rule' => 'numeric'
		)
	);

	public $belongsTo = array(
		'ProjectStatus' => array()
	);
}
?>