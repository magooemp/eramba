<?php
class SecurityServiceMaintenance extends AppModel {
	public $validate = array(
		
	);

	public $belongsTo = array(
		'SecurityService' => array(),
		'User' => array()
	);
}
?>