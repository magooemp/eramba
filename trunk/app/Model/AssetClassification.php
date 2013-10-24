<?php
class AssetClassification extends AppModel {
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