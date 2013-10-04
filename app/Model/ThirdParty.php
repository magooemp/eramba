<?php
class ThirdParty extends AppModel {
	public $name = 'ThirdParty';

	public $validate = array(
		'name' => array(
			'rule' => 'notEmpty',
			'required' => true
		),
		'description' => array(
			//'rule' => 'notEmpty'
		),
		/*'type_id' => array(
			'rule' => 'notEmpty',
			'required' => true
		)*/
	);
}
?>