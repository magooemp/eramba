<div class="row">

	<div class="col-md-12">
		<div class="widget">
			<div class="btn-toolbar">
				<div class="btn-group">
					<?php echo $this->Html->link( '<i class="icon-plus-sign"></i>' . __( 'Add New' ), array(
						'controller' => 'assets',
						'action' => 'add'
					), array(
						'class' => 'btn',
						'escape' => false
					) ); ?>
					
					<button class="btn dropdown-toggle" data-toggle="dropdown"><?php echo __( 'Actions' ); ?> <span class="caret"></span></button>
					<ul class="dropdown-menu pull-right" style="text-align: left;">
						<li><a href="#"><i class="icon-file"></i> <?php echo __( 'Export' ); ?></a></li>
					</ul>
				</div>
			</div>
		</div>

		<?php if ( ! empty( $data ) ) : ?>
			<?php foreach ( $data as $entry ) : ?>
				<div class="widget box">
					<div class="widget-header">
						<h4><?php echo __( 'BU Asset Name' ); ?>: <?php echo $entry['BusinessUnit']['name']; ?></h4>
					</div>
					<div class="widget-content">
						<?php if ( ! empty( $entry['Asset'] ) ) : ?>
							<?php foreach ( $entry['Asset'] as $asset ) : ?>
								<div class="widget box widget-closed">
									<div class="widget-header">
										<h4><?php echo __( 'Asset' ); ?>: <?php echo $asset['name']; ?></h4>
										<div class="toolbar no-padding">
											<div class="btn-group">
												<span class="btn btn-xs widget-collapse"><i class="icon-angle-up"></i></span>
												<span class="btn btn-xs dropdown-toggle" data-toggle="dropdown">
													<?php echo __( 'Manage' ); ?> <i class="icon-angle-down"></i>
												</span>
												<ul class="dropdown-menu pull-right">
													<li><?php echo $this->Html->link( '<i class="icon-pencil"></i> ' . __( 'Edit' ), array(
														'controller' => 'assets',
														'action' => 'edit',
														$asset['id']
													), array(
														'escape' => false
													) ); ?></li>
													<li><?php echo $this->Html->link( '<i class="icon-trash"></i> ' . __( 'Delete' ), array(
														'controller' => 'assets',
														'action' => 'delete',
														$asset['id']
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
													<th><?php echo __( 'Description' ); ?></th>
													<th><?php echo __( 'Type' ); ?></th>
													<th><?php echo __( 'Label' ); ?></th>
													<th><?php echo __( 'Legal Constrain' ); ?></th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td><?php echo $asset['description']; ?></td>
													<td><?php echo isset( $asset['AssetMediaType']['name'] ) ? $asset['AssetMediaType']['name'] : ''; ?></td>
													<td><?php echo isset( $asset['AssetLabel']['name'] ) ? $asset['AssetLabel']['name'] : ''; ?></td>
													<td><?php echo isset( $asset['Legal']['name'] ) ? $asset['Legal']['name'] : ''; ?></td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							<?php endforeach; ?>

						<?php else : ?>
							<?php echo $this->element( 'not_found', array(
								'message' => __( 'No Assets related to Business Units found.' )
							) ); ?>
						<?php endif; ?>

					</div>
				</div>

			<?php endforeach; ?>

			<?php //echo $this->element( CORE_ELEMENT_PATH . 'pagination' ); ?>
		<?php else : ?>
			<?php echo $this->element( 'not_found', array(
				'message' => __( 'No Business Units found.' )
			) ); ?>
		<?php endif; ?>













		<!--<div class="widget">
			<?php if ( ! empty( $data ) ) : ?>
				<table class="table table-hover table-striped table-bordered table-highlight-head">
					<thead>
						<tr>
							<th><?php echo $this->Paginator->sort( 'Asset.name', __( 'Name' ) ); ?></th>
							<th><?php echo $this->Paginator->sort( 'Asset.description', __( 'Description' ) ); ?></th>
							<th class="align-center"><?php echo __( 'Action' ); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ( $data as $entry ) : ?>
							<tr>
								<td><?php echo $entry['Asset']['name']; ?></td>
								<td><?php echo $entry['Asset']['description']; ?></td>
								<td class="align-center">
									<?php echo $this->element( 'action_buttons', array( 
										'id' => $entry['Asset']['id'],
										'controller' => 'assets'
									) ); ?>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>

				<?php echo $this->element( CORE_ELEMENT_PATH . 'pagination' ); ?>
			<?php else : ?>
				<?php echo $this->element( 'not_found', array(
					'message' => __( 'No Asset Indentification found.' )
				) ); ?>
			<?php endif; ?>

		</div>-->
	</div>

</div>