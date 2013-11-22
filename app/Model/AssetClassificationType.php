<?php
class AssetClassificationType extends AppModel {
	public $validate = array(
		'name' => array(
			'rule' => 'notEmpty',
			'required' => true
		)
	);

	public $hasMany = array(
		'AssetClassification' => array()
	);
}
?>