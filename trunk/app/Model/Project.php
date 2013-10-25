<?php
class Project extends AppModel {
	public $validate = array(
		'title' => array(
			'rule' => 'notEmpty',
			'required' => true
		),
		'description' => array(
		)
	);

	public $belongsTo = array(
		'ProjectStatus' => array()
	);
}
?>