<?php
class AssetLabel extends AppModel {
	public $validate = array(
		'name' => array(
			'rule' => 'notEmpty',
			'required' => true
		)
	);
}
?>