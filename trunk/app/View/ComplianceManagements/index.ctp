<div class="row">

	<div class="col-md-12">
		<div class="widget">
			<div class="btn-toolbar">
				<div class="btn-group">
					<button class="btn dropdown-toggle" data-toggle="dropdown"><?php echo __( 'Actions' ); ?> <span class="caret"></span></button>
					<ul class="dropdown-menu pull-right" style="text-align: left;">
						<li><a href="#"><i class="icon-file"></i> <?php echo __( 'Export' ); ?></a></li>
					</ul>
				</div>
			</div>
		</div>

		<?php if ( ! empty( $data ) ) : ?>
			<?php foreach ( $data as $entry ) : ?>
				<div class="widget box widget-closed">
					<div class="widget-header">
						<h4><?php echo __( 'Third Party' ); ?>: <?php echo $entry['ThirdParty']['name']; ?></h4>
						<div class="toolbar no-padding">
							<div class="btn-group">
								<span class="btn btn-xs widget-collapse"><i class="icon-angle-up"></i></span>
								<span class="btn btn-xs dropdown-toggle" data-toggle="dropdown">
									<?php echo __( 'Manage' ); ?> <i class="icon-angle-down"></i>
								</span>
								<ul class="dropdown-menu pull-right">
									<li><?php echo $this->Html->link( '<i class="icon-search"></i> ' . __( 'Analyze' ), array(
										'controller' => 'complianceManagements',
										'action' => 'analyze',
										$entry['ThirdParty']['id']
									), array(
										'escape' => false
									) ); ?></li>
								</ul>
							</div>
						</div>
					</div>
					<div class="widget-content" style="display:none;">
						<table class="table table-hover table-striped table-bordered table-highlight-head">
							<thead>
								<tr>
									<th><?php echo __( '% Strategy Mitigate' ); ?></th>
									<th><?php echo __( '% Strategy NA' ); ?></th>
									<th><?php echo __( '% Missing Controls' ); ?></th>
									<th><?php echo __( '% Failed Controls' ); ?></th>
									<th><?php echo __( '% Comp. On-Going' ); ?></th>
									<th><?php echo __( '% Compliant' ); ?></th>
									<th><?php echo __( '% Non-Compliant' ); ?></th>
									<th><?php echo __( '% Comp. N/A' ); ?></th>
									<th><?php echo __( '# Incident' ); ?></th>
									<th><?php echo __( '# Open Audit Items' ); ?></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>xx %</td>
									<td>xx %</td>
									<td>xx %</td>
									<td>xx %</td>
									<td>xx %</td>
									<td>xx %</td>
									<td>xx %</td>
									<td>xx %</td>
									<td>xx</td>
									<td>xx</td>
								</tr>
							</tbody>
						</table>

						<div class="widget box widget-closed">
							<div class="widget-header">
								<h4><?php echo __( 'Compliance Issues' ); ?></h4>
								<div class="toolbar no-padding">
									<div class="btn-group">
										<span class="btn btn-xs widget-collapse"><i class="icon-angle-up"></i></span>
									</div>
								</div>
							</div>
							<div class="widget-content" style="display:none;">
								<table class="table table-hover table-striped table-bordered table-highlight-head">
									<thead>
										<tr>
											<th><?php echo __( 'Compliance Package Item' ); ?></th>
											<th><?php echo __( 'Type' ); ?></th>
											<th><?php echo __( 'Name' ); ?></th>
											<th><?php echo __( 'Status' ); ?></th>
										</tr>
									</thead>
									
									<?php echo $this->element( 'compliance_management_issues', array(
										'compliance_packages' => $entry['CompliancePackage']
									) ); ?>

								</table>
							</div>
						</div>

					</div>
				</div>

			<?php endforeach; ?>

			<?php echo $this->element( CORE_ELEMENT_PATH . 'pagination' ); ?>
		<?php else : ?>
			<?php echo $this->element( 'not_found', array(
				'message' => __( 'No Third Parties found.' )
			) ); ?>
		<?php endif; ?>



	</div>

</div>