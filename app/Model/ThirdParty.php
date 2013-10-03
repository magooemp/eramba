<?php
class ThirdParty extends AppModel {
	public $name = 'ThirdParty';
	public $useTable = 'tp_tbl';
	public $primaryKey = 'tp_id';

	public $validate = array(
		'tp_name' => array(
			'rule' => 'notEmpty',
			'required' => true
		),
		'tp_description' => array(
			//'rule' => 'notEmpty'
		),
		'tp_type_id' => array(
			'rule' => 'notEmpty',
			'required' => true
		)
	);
}
?>