<?php
$selected = null;
if ( isset( $day ) && isset( $month ) ) {
	$selected = array(
		'day' => $day,
		'month' => $month
	);
}

$after = '</div>';
if ( $formKey != '0' ) {
	$after .= '<i class="icon icon-remove remove-parent" onClick="removeParent(this);" title="' . __( 'Remove' ) . '"></i>';
}
?>
<?php echo $this->Form->input( $model . '.audit_calendar.' . $formKey, array(
	'type' => 'date',
	'dateFormat' => 'DM',
	'label' => false,
	'separator' => '</div><div class="select-wrapper">',
	'before' => '<div class="select-wrapper">',
	'after' => $after,
	'class' => 'form-control',
	'selected' => $selected
) ); ?>