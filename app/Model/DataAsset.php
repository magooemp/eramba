<?php
class DataAsset extends AppModel {
	public $validate = array(
		'data_asset_status_id' => array(
			'rule' => 'notEmpty',
			'required' => true
		)
	);

	public $belongsTo = array(
		'DataAssetStatus' => array()
	);

	public $hasAndBelongsToMany = array(
		'SecurityService' => array(),
		'BusinessUnit' => array(),
		'ThirdParty' => array()
	);
}
?>