<?php
class ThirdPartiesType extends AppModel {
	public $name = 'ThirdPartiesType';
	public $useTable = 'tp_type_tbl';
	public $primaryKey = 'tp_type_id';

	/*public $validate = array(
		'tp_type_name' => array(
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
	);*/
}
?>