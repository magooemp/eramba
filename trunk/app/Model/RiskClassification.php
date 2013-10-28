<?php
class RiskClassification extends AppModel {
	public $validate = array(
		'name' => array(
			'rule' => 'notEmpty',
			'required' => true
		),
		'value' => array(
			'rule' => 'numeric'
		)
	);

	public $belongsTo = array(
		'RiskClassificationType' => array()
	);
}
?>