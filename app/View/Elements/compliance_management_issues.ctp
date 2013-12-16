<tbody>
<?php foreach ( $compliance_packages as $compliance_package ) : ?>
	<?php foreach ( $compliance_package['CompliancePackageItem'] as $compliance_package_item ) : ?>
	<?php if ( empty( $compliance_package_item['ComplianceManagement'] ) ) continue; ?>

		<?php
		$today = CakeTime::format( 'Y-m-d', CakeTime::fromString( 'now' ) );
		$notification = '';
		if ( $compliance_package_item['ComplianceManagement']['ComplianceException']['expiration'] > $today ) {
			$notification = '<span class="label label-danger">' . __( 'Expired' ) . '</span>';
		}
		?>
		<?php if ( $notification ) : ?>
			<tr>
				<td><?php echo $compliance_package_item['item_id'] . ' - ' . $compliance_package_item['name']; ?></td>
				<td><?php echo __( 'Compliance Exception' ); ?></td>
				<td><?php echo $compliance_package_item['ComplianceManagement']['ComplianceException']['title']; ?></td>
				<td><?php echo $notification; ?></td>
			</tr>
		<?php endif; ?>

		<?php foreach ( $compliance_package_item['ComplianceManagement']['SecurityService'] as $security_service ) : ?>
		<?php
		$msg = array();
		if ( ! $security_service['status']['all_done'] ) {
			$msg[] = '<span class="label label-warning">' . __( 'Missing audits.' ) . '</span>';
			
		}
		if ( ! $security_service['status']['last_passed'] ) {
			$msg[] = '<span class="label label-danger">' . __( 'Last audit failed.' ) . '</span>';
		}

		if ( $security_service['status']['all_done'] && $security_service['status']['last_passed'] ) {
			$msg[] = '<span class="label label-success">' . __( 'No audit issues.' ) . '</span>';
		}
		if ( ! $security_service['maintenanceStatus']['all_done'] ) {
			$msg[] = '<span class="label label-warning">' . __( 'Missing maintenances.' ) . '</span>';
			
		}
		if ( ! $security_service['maintenanceStatus']['last_passed'] ) {
			$msg[] = '<span class="label label-danger">' . __( 'Last maintenance failed.' ) . '</span>';
		}

		if ( $security_service['maintenanceStatus']['all_done'] && $security_service['maintenanceStatus']['last_passed'] ) {
			$msg[] = '<span class="label label-success">' . __( 'No maintenance issues.' ) . '</span>';
		}
		?>
		<tr>
			<td><?php echo $compliance_package_item['item_id'] . ' - ' . $compliance_package_item['name']; ?></td>
			<td><?php echo __( 'Security Service' ); ?></td>
			<td><?php echo $security_service['name']; ?></td>
			<td><?php echo implode( '<br />', $msg ); ?></td>
		</tr>
		<?php endforeach; ?>

		<?php foreach ( $compliance_package_item['ComplianceManagement']['SecurityPolicy'] as $security_policy ) : ?>
		<?php
		$notification = '';
		if ( $security_policy['status'] == SECURITY_POLICY_DRAFT ) {
			$notification = '<span class="label label-warning">' . __( 'Draft' ) . '</span>';
		}
		?>
		<?php if ( $notification ) : ?>
		<tr>
			<td><?php echo $compliance_package_item['item_id'] . ' - ' . $compliance_package_item['name']; ?></td>
			<td><?php echo __( 'Security Policy' ); ?></td>
			<td><?php echo $security_policy['index']; ?></td>
			<td><?php echo $notification; ?></td>
		</tr>
		<?php endif; ?>
		<?php endforeach; ?>

	<?php endforeach; ?>
<?php endforeach; ?>
</tbody>