<div class="row">

	<div class="col-md-12">
		<div class="widget">
			<div class="btn-toolbar">
				<div class="btn-group">
					<?php echo $this->Html->link( '<i class="icon-plus-sign"></i>' . __( 'Add New' ), array(
						'controller' => 'businessUnits',
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
						<h4><?php echo $entry['BusinessUnit']['name']; ?></h4>
						<div class="toolbar no-padding">
							<div class="btn-group">
								<span class="btn btn-xs widget-collapse"><i class="icon-angle-down"></i></span>
								<span class="btn btn-xs dropdown-toggle" data-toggle="dropdown">
									<?php echo __( 'Manage' ); ?> <i class="icon-angle-down"></i>
								</span>
								<ul class="dropdown-menu pull-right">
									<li><?php echo $this->Html->link( '<i class="icon-plus-sign"></i> ' . __( 'Add Process' ), array(
										'controller' => 'processes',
										'action' => 'add',
										$entry['BusinessUnit']['id']
									), array(
										'escape' => false
									) ); ?></li>
									<li><?php echo $this->Html->link( '<i class="icon-pencil"></i> ' . __( 'Edit Unit' ), array(
										'controller' => 'businessUnits',
										'action' => 'edit',
										$entry['BusinessUnit']['id']
									), array(
										'escape' => false
									) ); ?></li>
									<li><?php echo $this->Html->link( '<i class="icon-trash"></i> ' . __( 'Delete Unit' ), array(
										'controller' => 'businessUnits',
										'action' => 'delete',
										$entry['BusinessUnit']['id']
									), array(
										'escape' => false
									) ); ?></li>
								</ul>
							</div>
						</div>
					</div>
					<div class="widget-content">
						<?php if ( ! empty( $entry['Process'] ) ) : ?>
							<table class="table table-hover table-striped">
								<thead>
									<tr>
										<th><?php echo __( 'Process Name' ); ?></th>
										<th><?php echo __( 'Process Description' ); ?></th>
										<th><?php echo __( 'RTO' ); ?></th>
										<th class="align-center"><?php echo __( 'Action' ); ?></th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ( $entry['Process'] as $process ) : ?>
									<tr>
										<td><?php echo $process['name']; ?></td>
										<td><?php echo $process['description']; ?></td>
										<td><?php echo $process['rto']; ?></td>
										<td class="align-center">
											<?php echo $this->element( 'action_buttons', array( 
												'id' => $process['id'],
												'controller' => 'processes'
											) ); ?>
										</td>
									</tr>
									<?php endforeach ; ?>
								</tbody>
							</table>
						<?php else : ?>
							<?php echo $this->element( 'not_found', array(
								'message' => __( 'No Business Processes found.' )
							) ); ?>
						<?php endif; ?>

					</div>
				</div>

			<?php endforeach; ?>

			<?php echo $this->element( CORE_ELEMENT_PATH . 'pagination' ); ?>
		<?php else : ?>
			<?php echo $this->element( 'not_found', array(
				'message' => __( 'No Business Units found.' )
			) ); ?>
		<?php endif; ?>

	</div>

</div>