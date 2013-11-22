<?php
class SecurityServiceAudit extends AppModel {
	public $validate = array(
		
	);

	public $belongsTo = array(
		'SecurityService' => array(),
		'User' => array()
	);
}
?>