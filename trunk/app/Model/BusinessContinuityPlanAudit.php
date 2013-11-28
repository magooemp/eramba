<?php
class BusinessContinuityPlanAudit extends AppModel {
	public $validate = array(
	);

	public $belongsTo = array(
		'BusinessContinuityPlan' => array(),
		'User' => array()
	);
}
?>