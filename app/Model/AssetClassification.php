<?php
class AssetClassification extends AppModel {
	public $validate = array(
		'name' => array(
			'rule' => 'notEmpty',
			'required' => true,
			'allowEmpty' => false
		),
		'criteria' => array(
		)
	);

	public $belongsTo = array(
		'AssetClassificationType' => array()
	);
}
?>