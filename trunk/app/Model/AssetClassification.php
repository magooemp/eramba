<?php
class AssetClassification extends AppModel {
	public $name = 'AssetClassification';

	public $validate = array(
		'name' => array(
			'rule' => 'notEmpty',
			'required' => true
		),
		'criteria' => array(
			//'rule' => 'notEmpty'
		)
	);

	public $belongsTo = array(
		'AssetClassificationType' => array()
	);
}
?>