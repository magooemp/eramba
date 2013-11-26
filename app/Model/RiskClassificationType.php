<?php
class RiskClassificationType extends AppModel {
	public $validate = array(
		'name' => array(
			'rule' => 'notEmpty',
			'required' => true
		)
	);

	public $hasMany = array(
		'RiskClassification' => array()
	);
}
?>