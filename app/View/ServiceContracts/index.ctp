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
				<?php
				$today = CakeTime::format( 'Y-m-d', CakeTime::fromString( 'now' ) );
				$extra_class = '';
				foreach ( $entry['ServiceContract'] as $service_contract ) {
					if ( ! $extra_class && $service_contract['end'] > $today ) {
						$extra_class = 'widget-header-alert';
					}
				}
				?>
				<div class="widget box widget-closed">
					<div class="widget-header <?php echo $extra_class; ?>">
						<h4><?php echo $entry['ThirdParty']['name']; ?></h4>
						<div class="toolbar no-padding">
							<div class="btn-group">
								<span class="btn btn-xs widget-collapse"><i class="icon-angle-up"></i></span>
								<span class="btn btn-xs dropdown-toggle" data-toggle="dropdown">
									<?php echo __( 'Manage' ); ?> <i class="icon-angle-down"></i>
								</span>
								<ul class="dropdown-menu pull-right">
									<li><?php echo $this->Html->link( '<i class="icon-eye-open"></i> ' . __( 'View Third Party' ), array(
										'controller' => 'thirdParties',
										'action' => 'edit',
										$entry['ThirdParty']['id']
									), array(
										'escape' => false
									) ); ?></li>
									<li><?php echo $this->Html->link( '<i class="icon-plus-sign"></i> ' . __( 'Add Service Contract' ), array(
										'controller' => 'serviceContracts',
										'action' => 'add',
										$entry['ThirdParty']['id']
									), array(
										'escape' => false
									) ); ?></li>
								</ul>
							</div>
						</div>
					</div>
					<div class="widget-content" style="display:none;">
						<?php if ( ! empty( $entry['ServiceContract'] ) ) : ?>
							<table class="table table-hover table-striped">
								<thead>
									<tr>
										<th><?php echo __( 'Contract Name' ); ?></th>
										<th><?php echo __( 'Contract Description' ); ?></th>
										<th><?php echo __( 'Value' ); ?></th>
										<th><?php echo __( 'Start Date' ); ?></th>
										<th><?php echo __( 'End Date' ); ?></th>
										<th><?php echo __( 'Status' ); ?></th>
										<th class="align-center"><?php echo __( 'Action' ); ?></th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ( $entry['ServiceContract'] as $service_contract ) : ?>
									<tr>
										<td><?php echo $service_contract['name']; ?></td>
										<td><?php echo $service_contract['description']; ?></td>
										<td><?php echo $service_contract['value']; ?></td>
										<td><?php echo $service_contract['start']; ?></td>
										<td><?php echo $service_contract['end']; ?></td>
										<?php
										$notification = '<span class="label label-success">' . __( 'Not Expired' ) . '</span>';
										if ( $service_contract['end'] > $today ) {
											$notification = '<span class="label label-danger">' . __( 'Expired' ) . '</span>';
										}
										?>
										<td><?php echo $notification; ?></td>
										<td class="align-center">
											<?php echo $this->element( 'action_buttons', array( 
												'id' => $service_contract['id'],
												'controller' => 'serviceContracts'
											) ); ?>
										</td>
									</tr>
									<?php endforeach ; ?>
								</tbody>
							</table>
						<?php else : ?>
							<?php echo $this->element( 'not_found', array(
								'message' => __( 'No Service Contracts found.' )
							) ); ?>
						<?php endif; ?>

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