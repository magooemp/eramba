<?php
class Group extends AppModel {
	public $name = 'Group';
	public $actsAs = array(
		'Acl' => array('type' => 'requester')
	);
	
	public $validate = array(
		'name' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty'
			),
			'unique' => array(
				'rule' => 'isUnique'
			)
		),
	);
	
	public function parentNode() {
		return null;
	}
}