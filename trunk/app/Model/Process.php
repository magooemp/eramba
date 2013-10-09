<?php
class Process extends AppModel {
	public $name = 'Process';

	public $validate = array(
	);

	public $belongsTo = array(
		'BusinessUnit' => array()
	);
}
?>