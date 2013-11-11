<?php
class ProjectExpense extends AppModel {
	public $validate = array(
		'amount' => array(
			'rule' => 'numeric',
			'required' => true
		),
		'date' => array(
			'rule' => 'date',
			'required' => true
		)
	);

	public $belongsTo = array(
		'Project' => array()
	);
}
?>