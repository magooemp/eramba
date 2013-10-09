<?php
class ThirdParty extends AppModel {
	public $name = 'ThirdParty';

	public $validate = array(
		'name' => array(
			'rule' => 'notEmpty',
			'required' => true
		),
		'description' => array(
		)
	);

	public $belongsTo = array(
		'ThirdPartyType' => array(
			//'foreignKey'  => 'third_party_type_id',
			//'fields' => 'name'
		)
	);
}
?>