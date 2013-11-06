<?php
class ComplianceFinding extends AppModel {
	public $validate = array(
		'title' => array(
			'rule' => 'notEmpty',
			'required' => true,
			'allowEmpty' => false
		),
		'deadline' => array(
			'rule' => 'date'
		)
	);

	public $belongsTo = array(
		'ComplianceFindingStatus' => array()
	);
}
?>