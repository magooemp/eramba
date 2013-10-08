<?php
class User extends AppModel {
	public $name = 'User';
	public $actsAs = array(
		
	);
	
	public $validate = array(
		'pass' => array (
			'between' => array(
				'rule' => array('between', 6, 30)
			),
			'compare' => array(
				'rule' => array('compare_passoword', 'pass2')
			)
		),
		'email' => array(
			'email' => array(
				'rule' => 'email',
				'required' => true
			),
			'notEmpty' => array(
				'rule' => 'notEmpty'
			),
		),
		'login' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty'
			),
			'unique' => array(
				'rule' => 'isUnique'
			)
		),
		'name' => array(
			'rule' => 'notEmpty',
			'required' => true
		),
		'group_id' => array(
			'rule' => 'notEmpty',
			'required' => true
		)
	);

	public $belongsTo = array (
		'Group'
	);

	public function compare_passoword($pass1 = null, $pass2 = null) {

		foreach ($pass1 as $key => $value) {
			if ($value != $this->data[$this->name][$pass2]) {
				return false;
			}
			else continue;
		}
		return true;
	}
}
?>