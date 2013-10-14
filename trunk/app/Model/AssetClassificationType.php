<?php
class AssetClassificationType extends AppModel {
	public $name = 'AssetClassificationType';

	public $validate = array(
		'name' => array(
			'rule' => 'notEmpty',
			'required' => true
		)
	);
}
?>