<?php
class Legal extends AppModel {
	public $name = 'Legal';
	public $useTable = 'legal_tbl';
	public $primaryKey = 'legal_id';

	public $validate = array(
		'legal_name' => array(
			'rule' => 'notEmpty',
			'required' => true
		),
		'legal_description' => array(
			//'rule' => 'notEmpty'
		),
		'legal_risk_magnifier' => array(
			//'rule' => 'notEmpty'
		)
	);
}
?>