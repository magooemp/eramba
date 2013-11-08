<?php
class ProjectAchievement extends AppModel {
	public $validate = array(
		'user_id' => array(
			'rule' => 'notEmpty',
			'required' => true
		),
		'date' => array(
			'rule' => 'date',
			'required' => true
		),
		'completion' => array(
			'rule' => 'numeric',
			'required' => true
		)
	);

	public $belongsTo = array(
		'User' => array()
	);
}
?>