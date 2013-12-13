<?php
class Asset extends AppModel {
	public $actsAs = array(
		'Containable'
	);

	public $validate = array(
		'name' => array(
			'rule' => 'notEmpty',
			'required' => true,
			'allowEmpty' => false
		),
		'business_unit_id' => array(
			'rule' => array( 'multiple', array( 'min' => 1 ) )
		),
		'asset_media_type_id' => array(
			'rule' => 'notEmpty',
			'required' => true
		)
	);

	public $belongsTo = array(
		'AssetMediaType' => array(),
		'AssetLabel' => array(),
		'Legal' => array(),
		'AssetOwner' => array(
			'className' => 'BusinessUnit',
			'foreignKey' => 'asset_owner_id'
		),
		'AssetGuardian' => array(
			'className' => 'BusinessUnit',
			'foreignKey' => 'asset_guardian_id'
		),
		'AssetUser' => array(
			'className' => 'BusinessUnit',
			'foreignKey' => 'asset_user_id'
		),
		'AssetMainContainer' => array(
			'className' => 'Asset',
			'foreignKey' => 'asset_id'
		)
	);

	public $hasMany = array(
		'DataAsset' => array()
	);

	public $hasAndBelongsToMany = array(
		'BusinessUnit' => array(),
		'AssetClassification' => array(),
		'Risk' => array()
	);
}
?>